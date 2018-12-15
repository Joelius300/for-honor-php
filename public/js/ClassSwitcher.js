class ClassSwitcher {
    constructor(defaults, avaiablePoints) {
        this.defaults = defaults;
        this.avaiablePoints = avaiablePoints;
    }

    Refresh() {
        var select = document.getElementById('classSelect');
        var value = select.options[select.selectedIndex].value;

        var classDefaults = this.defaults[value]

        document.getElementById('healthValue').value = classDefaults.baseHealth;
        document.getElementById('strengthValue').value = classDefaults.baseStrength;
        document.getElementById('classDescription').innerText = classDefaults.description; //.replace("/\n/g", "\\n");
        document.getElementById('classImage').src = classDefaults.picURL;

        SelectBarContainer.avaiablePoints = this.avaiablePoints;
        SelectBarContainer.CheckAvaiablePoints();
    }
}