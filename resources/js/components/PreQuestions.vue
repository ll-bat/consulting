<template>
    <div class="m-auto text-center w-100" id="pre-questions">
        <div class="" style="height: 500px" v-if="showNewCopyButtons">
            <div class="row justify-content-center" style="margin-top: 10%">
                <div class="col-md-6 col-sm-12 card rounded-10 m-2 border-0 pb-2 px-4 card-hover" @click="createNew">
                    <div class="card-body">
                        <p class="text-lg text-primary m-1 user-select-none">
                            <i class="fa fa-plus mr-2"> </i>
                            ახლის შექმნა
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 card rounded-10 m-2 pb-2 border-0 partial-shadow card-hover" @click="copyDoc">
                    <div class="card-body border-0 ">
                        <p class="text-lg text-danger m-1 user-select-none">
                            <i class="nc-icon nc-paper mr-2"></i>
                            არსებულის კოპირება
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div v-if="showUserDocs">
                <button type="button" class="btn btn-primary d-none" id="user-docs-modal-button" data-toggle="modal"
                        data-target="#user-docs-modal">
                    Open modal
                </button>

                <!-- The Modal -->
                <div class="modal fade" id="user-docs-modal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title"> აირჩიეთ დოკუმენტი </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body" style="min-height: 500px">

                                <div class="spinner spinner-border text-purple" v-if="showDocSpinner" style="font-size: 3.7rem; width: 80px; height: 80px; margin-top: 180px"></div>

                                <div v-if="!showDocSpinner">
                                    <div class="row justify-content-center mb-4" @keyup="searchDebounced()">
                                        <div class="col-xl-4 col-lg-5 col-md-7 col-sm-10 col-12">
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control"
                                                       v-model="queryWord"
                                                       style="font-size: 1.1rem;" placeholder="ძებნა">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary m-0" type="submit">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <template v-for="doc in filteredDocs" >
                                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-11" @click="chooseUserDoc(doc.id)">
                                                <div class="hover pt-3 rounded-10 pointer">
                                                    <div class="text-center">
                                                        <img src="/icons/document2.png" style="max-width: 70px" />
                                                        <p class="p-2 text-break"> {{ doc.filename }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <div class="col-12 text-center" v-if="filteredDocs.length < 1">
                                            <h5 class="m-5 text-muted"> ასეთი დოკუმენტი არ მოიძებნა </h5>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div v-if="showDocObjects">
            <div class="m-auto" style="max-width: 700px">
                <p> აირჩიეთ ობიექტი </p>
                <div v-for="object in objects">
                    <div class="card card-hover border-0 partial-shadow rounded-10" @click="chooseDocObject(object.id)">
                        <div class="card-body d-flex ">
                            <img src="/icons/object.png" width="30" height="30"/>
                            <p class="ml-4 mt-1"> {{ object.name }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="showDocumentName" class="m-auto" style="max-width: 700px">
            <div class="card rounded-5 border-0">
                <div class="card-body">
                    <p class="my-4"> დაარქვით დოკუმენტს სახელი </p>
                    <div class='card-body ns-input-container pl-4 pb-3 mt-0 pt-0'>
                      <textarea type="text"
                                rows='1'
                                class="form-control border-0 border-bottom-dotted"
                                placeholder='სახელი'
                                v-model="filename"
                                onclick="$(this).next().addClass('ns-test-underline');$(this).removeClass('border-bottom-dotted')"
                                onblur="$(this).next().removeClass('ns-test-underline');$(this).addClass('border-bottom-dotted')"
                      ></textarea>
                        <div class="ns-underline" style='background-color:#e2479D !important;'></div>
                    </div>

                    <button class="btn btn-primary border-0 rounded-0 px-4 my-4" id="create-doc-button" @click="createDoc">
                        <span class="spinner-border spinner-border-sm d-none" id="create-doc-spinner"></span>
                        დოკუმენტის დაწყება
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import httpService from "../services/httpService";

export default {
    name: "preQuestions",
    props: {
        _objects: String,
        _docs: String,
    },
    data() {
        return {
            objects: null,
            docs: null,
            filteredDocs: null,
            showNewCopyButtons: true,
            isNew: false,
            objectId: false,
            docId: false,
            showDocObjects: false,
            showDocumentName: false,
            showUserDocs: false,
            showDocSpinner: false,
            spinnerTime: 800,
            queryWord: '',
            debouncedTime: null,
            filename: '',
        }
    },
    methods: {
        searchDebounced(){
            if (this.debouncedTime) {
                clearTimeout(this.debouncedTime);
            }
            this.debouncedTime = setTimeout(this.search, 300);
        },
        search() {
            this.filteredDocs = this.docs.filter(doc => doc.filename.indexOf(this.queryWord) !== -1);
        },
        createNew() {
            this.isNew = true;
            this.passFirstPart();
        },
        passFirstPart() {
            this.showNewCopyButtons = false;
            this.showUserDocs = false;
            this.showDocObjects = true;
        },
        copyDoc() {
            this.showUserDocs = true;
            this.showDocs();
            this.queryWord = '';
            this.search();
        },
        showDocs() {
            this.showDocSpinner = true;
            tout(() => {
                this.showDocSpinner = false;
                this.spinnerTime = 0
            }, this.spinnerTime)
            tout(() => {
                $('#user-docs-modal-button').click();
            })
        },
        chooseUserDoc(docId) {
            this.isNew = false;
            this.docId = docId;
            $('.modal-backdrop').remove();
            $('#user-docs-modal .close').click();
            tout(() => {
                this.passFirstPart();
            }, 240)

        },
        chooseDocObject(id) {
            this.objectId = id;
            this.showDocObjects = false;
            this.showDocumentName = true;
        },
        async createDoc() {
            if (!this.filename) {
                alert("გთხოვთ, შეიყვანოთ სახელი");
                return;
            }

            if (this.isNew) {
                let data = {
                    isNew : true,
                    objectId: parseInt(this.objectId),
                    filename: this.filename.toString(),
                };

                const res = await httpService.post('/user/docs/prepare-doc', data).catch(err => {
                    alert('სამწუხაროდ შეცდომა დაფიქსირდა. სცადეთ თავიდან');
                    $('#create-doc-spinner').addClass('d-none');
                    $('#create-doc-button').removeClass('disabled');
                });
                if (res) {
                   window.location = '/user/questions';
                }
            } else {
                let data = {
                    isNew : false,
                    objectId: parseInt(this.objectId),
                    docId: parseInt(this.docId),
                    filename: this.filename.toString(),
                }

                const res = await httpService.post('/user/docs/prepare-doc', data).catch(err => {
                    alert('სამწუხაროდ შეცდომა დაფიქსირდა. სცადეთ თავიდან');
                    $('#create-doc-spinner').addClass('d-none');
                    $('#create-doc-button').removeClass('disabled');
                })

                if (res) {
                    window.location = '/user/questions';
                }
            }

            $('#create-doc-spinner').removeClass('d-none');
            $('#create-doc-button').addClass('disabled');
        }
    },
    created() {
        this.objects = JSON.parse(this._objects);
        this.docs = JSON.parse(this._docs);

        tout(() => {
            $1('pre-questions').style.height = window.screen.availHeight + 'px';
        })
    }

}
</script>

<style scoped>
.card-hover {
    cursor: pointer;
}
.card-hover:hover {
    background-color: #e8eceb;
}
.border-bottom-dotted {
    border-bottom: 1px dotted lightgrey !important;
}
.hover {
    border: 2px solid transparent;
}
.hover:hover {
    background-color: lightgrey;
}
.hover:active {
    transition: all .1s ease-in;
    background-color: #999696;
    border: 2px solid #8a8888
}
</style>
