function ChangeValue(name, diff) {
    var healthItems = document.getElementsByClassName(name);
    var hiddenInput = document.getElementById(name + 'Value');

    console.log(name + '  ' + hiddenInput.value);

    if (+hiddenInput.value + +diff > 0 && +hiddenInput.value + +diff <= healthItems.length) {
        hiddenInput.value = +hiddenInput.value + +diff;
    }

    console.log('Changed ' + name + hiddenInput.value + ' (diff = ' + diff + ')');

    Refresh(name);
}

function Refresh(name) {
    var healthItems = document.getElementsByClassName(name);
    var hiddenInput = document.getElementById(name + 'Value');

    for (var i = 0; i < healthItems.length; i++) {
        healthItems[i].style.backgroundColor = '#808080';
    }

    for (var j = 0; j < hiddenInput.value; j++) {
        healthItems[j].style.backgroundColor = '#000';
    }

    console.log('Refreshed');
}