export function createTransactionHistory(virtualcoin,transactiontype, amount, rateindollars, amountindollars, date, time){
    const data = {
        "virtualcoin" : virtualcoin,
        "transactiontype" : transactiontype,
        "otherinfo" : {
            amount,
            rateindollars,
            amountindollars,
            date,
            time,
        }
    }
    return data;
}
