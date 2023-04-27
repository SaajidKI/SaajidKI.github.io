const express = require("express");
const { MongoClient } = require("mongodb");
const app = express();
const port = 3000;
const uri = "mongodb+srv://Saajid:Neovenator02@cluster0.aan4j3f.mongodb.net/?retryWrites=true&w=majority";
const client = new MongoClient(uri);

app.use(express.urlencoded({ extended: true }));
app.get("/", (req, res) => {
  res.sendFile("/Users/misla/OneDrive/Documents/GitHub/SaajidKI.github.io/cs20/HW14/index.html");
});

app.post("/lookup", async (req, res) => {
  const searchTerm = req.body.searchTerm.trim();
  const searchType = req.body.searchType;

  try {
    await client.connect();

    const database = client.db("stock_ticker");
    const collection = database.collection("companies");
    let query;
    if (searchType === "symbol") {
      query = { ticker: searchTerm };
    } else {
      query = { name: { $regex: searchTerm, $options: "i" } };
    }

    const cursor = collection.find(query);
    const results = await cursor.toArray();
    if (results.length === 0) {
      res.send("No results found.");
    } else {
      let html = "";
      for (const { name, ticker, price } of results) {
        html += `<li><p>Company Name: ${name}</p><p>Stock Ticker: ${ticker}</p><p>Stock Price: ${price}</p></li>`;
      }
      res.send(`<ul>${html}</ul>`);
    }
  } catch (err) {
    console.error(err);
    res.send("An error occurred while looking up the company information.");
  } finally {
    await client.close();
  }
});

app.listen(port, () => {
  console.log(`App listening at http://localhost:${port}`);
});
