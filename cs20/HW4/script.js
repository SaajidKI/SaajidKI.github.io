function calculateOrder() {
    hotdogs = parseInt(document.getElementById("hotdogs").value);
    fries = parseInt(document.getElementById("fries").value);
    drinks = parseInt(document.getElementById("drinks").value);
  
    hotdogSubtotal = hotdogs * 4;
    friesSubtotal = fries * 3.5;
    drinkSubtotal = drinks * 1.75;
    subtotal = roundToTwoDecimals(hotdogSubtotal + friesSubtotal + drinkSubtotal);
  
    discount = 0;
    if (subtotal >= 20) {
      discount = roundToTwoDecimals(0.1 * subtotal);
    }
  
    taxRate = 0.0625;
    tax = roundToTwoDecimals(taxRate * subtotal);
  
    total = roundToTwoDecimals(subtotal - discount + tax);
  
    document.getElementById("hotdogQty").textContent = hotdogs;
    document.getElementById("hotdogSubtotal").textContent = roundToTwoDecimals(hotdogSubtotal);
    document.getElementById("friesQty").textContent = fries;
    document.getElementById("friesSubtotal").textContent = roundToTwoDecimals(friesSubtotal);
    document.getElementById("drinkQty").textContent = drinks;
    document.getElementById("drinkSubtotal").textContent = roundToTwoDecimals(drinkSubtotal);
    document.getElementById("subtotal").textContent = roundToTwoDecimals(subtotal);
    document.getElementById("discount").textContent = "-" + roundToTwoDecimals(discount);
    document.getElementById("tax").textContent = roundToTwoDecimals(tax);
    document.getElementById("total").textContent = roundToTwoDecimals(total);
  
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

  