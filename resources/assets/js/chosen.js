$(".urights").chosen({
    no_results_text: "Oops, nothing found!"
});

$(".storeDropDown").chosen({
    no_results_text: "Oops, nothing found!"
}).trigger("chosen:updated");

$(".reportfrequency").chosen();
