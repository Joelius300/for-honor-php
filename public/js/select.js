function ChangeValue(name, diff, selectedColor) {
    var healthItems = document.getElementsByClassName(name);
    var hiddenInput = document.getElementById(name + 'Value');

    console.log(name + '  ' + hiddenInput.value);

    if (+hiddenInput.value + +diff > 0 && +hiddenInput.value + +diff <= healthItems.length) {
        hiddenInput.value = +hiddenInput.value + +diff;
    }

    console.log('Changed ' + name + hiddenInput.value + ' (diff = ' + diff + ')');

    Refresh(name, selectedColor);
}

function Refresh(name, selectedColor) {
    var healthItems = document.getElementsByClassName(name);
    var hiddenInput = document.getElementById(name + 'Value');

    var color;

    if (selectedColor === undefined || selectedColor === '') {
        color = '#222';
    } else {
        color = selectedColor;
    }

    for (var i = 0; i < healthItems.length; i++) {
        healthItems[i].style.backgroundColor = '#808080';
    }

    for (var j = 0; j < hiddenInput.value; j++) {
        healthItems[j].style.backgroundColor = color;
    }

    console.log('Refreshed');
}