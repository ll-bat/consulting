const STATE = {
    loading: true,
    newDoc: true,
    processes: [],
    dangers: [],
    controls: [],
    ploss: [],
    udanger: [],
    info: [],
    processId: -1,
    dangerId: -1,
    elm: null,
    data: [],
    controlAnswers: [],
    fm: new FormData(),
    dangerSelect: [],
    currentDangers: [],
    currentControls: [],
    showDangers: false,
    showControls: false,
    showDangerLoader: false,
    showControlsLoader: false,
    helpers: {},
    exportId: null,
    focuses: false
}

export default STATE;
