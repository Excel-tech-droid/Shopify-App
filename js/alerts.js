// // type success error
// const hideAlert = () => {
//   const el = document.querySelector(".alerts");
//   if (el) el.parentElement.removeChild(el);
// };

// const showAlert = (type, msg) => {
//   hideAlert();
//   const markup = `<div class="alerts alerts--${type}">${msg}</div>`;
//   document.querySelector("body").insertAdjacentHTML("afterbegin", markup);
//   window.setTimeout(hideAlert, 4000);
// };

// // const remove = document.getElementById("remove");
// // remove.addEventListener("click", showAlert("success", "Item deleted"));

// const addTo = document.querySelectorAll("input.addto");
// addTo.forEach((el) =>
//   el.addEventListener(
//     "click",
//     function (e) {
//       showAlert("success", "Item Added");
//     },
//     false
//   )
// );

// const remove = document.querySelectorAll("span.remove");
// remove.forEach((el) =>
//   el.addEventListener(
//     "click",
//     function (e) {
//       showAlert("error", "Item Removed");
//     },
//     false
//   )
// );
