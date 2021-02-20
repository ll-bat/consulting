const STATE = {
    loading: true,
    newDoc: true,
    toBeWatched: false,
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
    completedDangers: {},
    helpers: {},
    showDangers: false,
    showControls: false,
    showDangerLoader: false,
    showControlsLoader: false,
    exportId: null,
    focuses: false
}

export default STATE;
