import { createTransactionHistory } from "./history.mjs";

const history = [];
const virtualcoin = "BTC";
const transactiontype = "buy";
const amount = 1000;
const rateindollars = 50;
const amountindollars = rateindollars*amount;
const today = new Date();

var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

console.log(date+" -- "+time);

var data = createTransactionHistory(virtualcoin,transactiontype, amount, rateindollars, amountindollars, date, time);

history.push(data);

date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
data = createTransactionHistory("ETH","sell", 10, 5, 50, date, time);

history.push(data);

            history.forEach(element => {
                console.log(element);
            });

history.forEach(element => {
    if(element.virtualcoin == "BTC"){
        console.log(element.otherinfo.amount);
    }
    else{
        console.log(element.virtualcoin);
    }
});