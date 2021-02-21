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
    sendData: [],
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
    unprocessedProcess: {},
    showDangers: false,
    showControls: false,
    showDangerLoader: false,
    showControlsLoader: false,
    exportId: null,
    focuses: false,
    isUpdate: false,
}

export default STATE;