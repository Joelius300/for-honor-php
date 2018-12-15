class SelectBar {

    constructor(name, selectedColor = '#222') {
        this.name = name;

        this.minusButton = document.getElementById(this.name + "Minus");
        this.plusButton = document.getElementById(this.name + "Plus");

        this.selectedColor = selectedColor == '' ? '#222' : selectedColor;
        this.unselectedColor = '#808080';

        this.healthItems = document.getElementsByClassName(this.name);
        this.hiddenInput = document.getElementById(this.name + 'Value');
    }


    ChangeValue(diff) {
        if (SelectBarContainer.avaiablePoints - +diff >= 0) {
            //console.log(this.name + ' ' + this.hiddenInput.value);
            if (+this.hiddenInput.value + +diff > 0 && +this.hiddenInput.value + +diff <= this.healthItems.length) {
                this.hiddenInput.value = +this.hiddenInput.value + +diff;

                SelectBarContainer.ChangeAvaiablePoints(+diff);

                //console.log('Changed ' + this.name + ' to ' + this.hiddenInput.value + ' (diff = ' + diff + ')');
            }
        }

        this.Refresh();
    }

    Refresh() {
        for (var i = 0; i < this.healthItems.length; i++) {
            this.healthItems[i].style.backgroundColor = this.unselectedColor;
        }

        for (var j = 0; j < this.hiddenInput.value; j++) {
            this.healthItems[j].style.backgroundColor = this.selectedColor;
        }

        this.CheckPoints();

        //console.log('Refreshed');
        //console.log(SelectBarContainer.avaiablePoints);
    }

    CheckPoints() {
        if (SelectBarContainer.avaiablePoints > 0) {
            this.HideMinus(+this.hiddenInput.value <= 1);
            this.HidePlus(+this.hiddenInput.value >= this.healthItems.length);
        } else {
            this.HideMinus(false);
            this.HidePlus(true);
        }
    }

    HidePlus(hide) {
        if (hide) {
            this.plusButton.style.visibility = 'hidden';
        } else {
            if (+this.hiddenInput.value < this.healthItems.length) {
                this.plusButton.style.visibility = 'visible';
            }
        }
    }

    HideMinus(hide) {
        if (hide) {
            this.minusButton.style.visibility = 'hidden';
        } else {
            if (+this.hiddenInput.value > 1) {
                this.minusButton.style.visibility = 'visible';
            }
        }
    }
}