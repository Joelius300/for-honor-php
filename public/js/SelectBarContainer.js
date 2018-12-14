class SelectBarContainer {
    static CheckAvaiablePoints() {
        for (let i = 0; i < SelectBarContainer.selects.length; i++) {
            SelectBarContainer.selects[i].HidePlus(SelectBarContainer.avaiablePoints <= 0);
        }
    }

    static ChangeAvaiablePoints(diff) {
        if (SelectBarContainer.avaiablePoints - +diff >= 0) {
            SelectBarContainer.avaiablePoints -= +diff;
        }

        SelectBarContainer.CheckAvaiablePoints();
    }
}

SelectBarContainer.selects = [];
SelectBarContainer.avaiablePoints;