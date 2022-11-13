
function padZeros(number, numZeros=1){
    return "0" + String(number).slice(-numZeros);
}