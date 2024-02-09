export const generateUniqueID = (digits = 5) => {
  var uniqueID = Math.floor(Math.random() * Math.pow(10, digits));
  return String(uniqueID).padStart(digits, '0');
 }