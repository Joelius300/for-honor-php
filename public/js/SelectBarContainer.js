class SelectBarContainer {
    static CheckAvaiablePoints() {
        for (let i = 0; i < SelectBarContainer.selects.length; i++) {
            SelectBarContainer.selects[i].CheckPoints();
        }
    }

    static ChangeAvaiablePoints(diff) {
        if (SelectBarContainer.avaiablePoints - +diff >= 0) {
            SelectBarContainer.avaiablePoints -= +diff;
        }

        document.getElementById('avaiablePointsInput').value = SelectBarContainer.avaiablePoints;

        SelectBarContainer.CheckAvaiablePoints();
    }
}

SelectBarContainer.selects = [];
SelectBarContainer.avaiablePoints;