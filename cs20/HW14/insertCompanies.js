const fs = require("fs");
const readline = require("readline");
const { MongoClient } = require("mongodb");

const uri = "mongodb+srv://Saajid:Neovenator02@cluster0.aan4j3f.mongodb.net/stock_ticker?retryWrites=true&w=majority";
const client = new MongoClient(uri);

async function run() {
  try {
    await client.connect();
    console.log("Connected to MongoDB");

    const database = client.db("stock_ticker");
    const collection = database.collection("companies");
    const fileStream = fs.createReadStream("companies.csv");
    const rl = readline.createInterface({
      input: fileStream,
      crlfDelay: Infinity,
    });

    for await (const line of rl) {
      const [name, ticker, price] = line.split(",");

      try {
        const result = await collection.insertOne({
          name: name.trim(),
          ticker: ticker.trim(),
          price: parseFloat(price.trim()),
        });
      } catch (err) {
        console.error(`Error inserting document: ${err}`);
      }
    }
    console.log("Successfully inserted all documents!");
  } catch (err) {
    console.error(`Error connecting to MongoDB: ${err}`);
  } finally {
    await client.close();
    console.log("Disconnected from MongoDB");
  }
}

run();
