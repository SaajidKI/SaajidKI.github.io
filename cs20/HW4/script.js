function calculateOrder() {
    hotdogs = prompt("How many hotdogs would you like?");
    fries = prompt("How many french fries would you like?");
    drinks = prompt("How many drinks would you like?");
  
    hotdogSubtotal = hotdogs * 4;
    friesSubtotal = fries * 3.5;
    drinkSubtotal = drinks * 1.75;
    subtotal = hotdogSubtotal + friesSubtotal + drinkSubtotal;
  
    discount = 0;
    total = 0;
    if (subtotal >= 20) {
        discount = roundToTwoDecimals(0.1 * subtotal);
    }
  
    taxRate = 0.0625;
    tax = taxRate * subtotal;
  
    total = roundToTwoDecimals(subtotal - discount + tax);
  
    document.getElementById("hotdogNum").textContent = hotdogs;
    document.getElementById("hotdogSubtotal").textContent = "$" + hotdogSubtotal;
    document.getElementById("friesNum").textContent = fries;
    document.getElementById("friesSubtotal").textContent = "$" + friesSubtotal;
    document.getElementById("drinkNum").textContent = drinks;
    document.getElementById("drinkSubtotal").textContent = "$" + drinkSubtotal;
    document.getElementById("subtotal").textContent = "$" + roundToTwoDecimals(subtotal);
    document.getElementById("discount").textContent = "-$" + roundToTwoDecimals(discount);
    document.getElementById("tax").textContent = "$" + roundToTwoDecimals(tax);
    document.getElementById("total").textContent = "$" + roundToTwoDecimals(total);
  
    document.getElementById("orderSummary").classList.remove("hidden");
}

function roundToTwoDecimals(num) {
    numStr = num.toString();
    dotIndex = numStr.indexOf(".");
    if (dotIndex === -1) {
        return numStr + ".00";
    } else if (numStr.length - dotIndex === 2) {
        return numStr + "0";
    } else {
        return numStr.substring(0, dotIndex + 3);
    }
}
