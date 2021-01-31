<template>
    <div class="position-relative w-100 h-100" style="" id="pre-questions">
        <div class="row justify-content-center" style="margin-top: -35px">
            <div class="col-xl-6 col-lg-9 col-md-11 col-12">
                <div class="m-auto bg-white p-3 pl-4 partial-shadow"
                     style="line-height: 2.1rem;border-bottom-left-radius: 15px; border-bottom-right-radius: 15px" v-if="!loading">
                    <template v-for="(b, i) in breadcrumb">
                        <span class="underline-on-hover mr-2" style="color: darkcyan" @click="toRoute(b.route)"> {{ b.name }}</span>
<!--                        <span class="mx-2" v-if="i !== breadcrumb.length - 1"> / </span>-->
                        <img src="/icons/right-arrow1.png"  class="mx-2" width="14" height="14"  v-if="i !== breadcrumb.length - 1" />
                    </template>
                </div>
            </div>
        </div>


        <div class="d-flex justify-content-center align-items-center"
             :class="{'h-100' : showNewCopyButtons || loading}">
            <div class="w-100 " style="" v-if="showNewCopyButtons & !loading">
                <div class="row justify-content-center" style="">
                    <div class="col-xl-6 col-lg-9 col-md-11 col-12 card rounded-10 m-2 border-0 pb-2 px-4 card-hover"
                         @click="createNew">
                        <div class="card-body text-center">
                            <p class="text-lg text-primary m-1 user-select-none">
                                <i class="fa fa-plus mr-2"> </i>
                                ახალი დოკუმენტის შექმნა
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-9 col-md-11 col-12 card rounded-10 m-2 pb-2 border-0 partial-shadow card-hover"
                         @click="copyDoc">
                        <div class="card-body border-0 text-center">
                            <p class="text-lg text-danger m-1 user-select-none">
                                <i class="nc-icon nc-paper mr-2"></i>
                                არსებულის კოპირება
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <div v-if="showUserDocs">
                <button type="button" class="btn btn-primary d-none" id="user-docs-modal-button" data-toggle="modal"
                        data-target="#user-docs-modal"></button>

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
                            <div class="modal-body text-center" style="min-height: 500px">

                                <div class="spinner spinner-border text-purple" v-if="showDocSpinner"
                                     style="font-size: 3.7rem; width: 80px; height: 80px; margin-top: 180px"></div>

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
                                        <template v-for="doc in filteredDocs">
                                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-11"
                                                 @click="chooseUserDoc(doc.id)">
                                                <div class="hover pt-3 rounded-10 pointer">
                                                    <div class="text-center">
                                                        <img src="/icons/document2.png" style="max-width: 70px"/>
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
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-9 col-md-11 col-12">
                    <div class="m-auto text-center mb-5" style="">
                        <p> აირჩიეთ ობიექტი </p>
                        <div v-for="object in objects">
                            <div class="card card-hover border-0 partial-shadow rounded-10" @click="chooseDocObject(object.id)">
                                <div class="card-body d-flex ">
                                    <img src="/icons/3d.png" width="30" height="30"/>
                                    <p class="ml-4 mt-1"> {{ object.name }} </p>
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                    </div>
                </div>
            </div>

        </div>


        <div v-if="showDocumentName"
             class="m-auto text-center d-flex justify-content-center align-items-center w-100 h-100">
            <div class="row justify-content-center w-100">
                <div class="col-xl-6 col-lg-9 col-md-11 col-12" :class="{'go-upper' : shouldGoUpper }"  style="max-width: 700px" >
                    <div class="card rounded-5 border-0 w-100" style="">
                        <div class="card-body">
                            <p class="my-4"> დაარქვით დოკუმენტს სახელი </p>
                            <div class='card-body ns-input-container pl-4 pb-3 mt-0 pt-0'>
                        <textarea type="text"
                                  rows='1'
                                  class="form-control border-0 border-bottom-dotted"
                                  placeholder='სახელი'
                                  v-model="filename"
                                  onclick="$(this).next().addClass('ns-test-underline');"
                                  onblur="$(this).next().removeClass('ns-test-underline');"
                        ></textarea>
                                <div class="ns-underline"
                                     style='background-color:#e2479D !important; height: 1px !important;'></div>
                            </div>

                            <button class="btn btn-primary border-0 rounded-0 px-4 my-4" id="create-doc-button"
                                    @click="nameDocument()">
                                <span class="spinner-border spinner-border-sm d-none" id="create-doc-spinner"></span>
                                შემდეგი
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div v-if="showFields">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-9 col-md-11 col-12">
                    <div class="m-auto text-center">
                        <p> აირჩიეთ სფერო </p>
                        <div v-for="field in fields">
                            <div class="card card-hover border-0 partial-shadow rounded-10"
                                 @click="chooseField(field.id)">
                                <div class="card-body d-flex ">
                                    <img src="/icons/slack_1.png" width="30" height="30"/>
                                    <p class="ml-4 mt-1"> {{ field.name }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showDocAbout">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-9 col-md-11 col-12">
                    <div class="m-auto text-center" style="max-width: 700px">
                        <div class="card rounded-5 border-0 w-100">
                            <p class="mt-4 mb-0 text-center"> შეავსეთ მონაცემები </p>
                            <div class="card-body">
                                <template v-for="obj in docAboutProperties">
                                    <p class="mt-4 mb-3 text-left ml-4 text-sm" :class="{'text-danger' : obj.hasError}">
                                        {{ obj.name }} <span v-if="obj.hasError"> * </span></p>
                                    <div class='card-body ns-input-container ml-4 pb-3 mt-0 pt-0'>
                            <textarea type="text"
                                      :rows="obj.rows || 1"
                                      class="form-control border-0 border-bottom-dotted p-1 pl-3 font-size-09-rem"
                                      :class="obj.class || ''"
                                      :placeholder='obj.placeholder'
                                      v-model="docAbout[obj.property]"
                                      onclick="$(this).next().addClass('ns-test-underline');$(this).addClass('border-bottom-transparent')"
                                      onblur="$(this).next().removeClass('ns-test-underline');$(this).removeClass('border-bottom-transparent')"
                            ></textarea>
                                        <div class="ns-underline"
                                             style='background-color:#63759b !important; height: 1px !important;'></div>
                                    </div>
                                </template>

                                <button class="btn btn-primary border-0 px-4 my-4" id="doc-about-button"
                                        @click="validateDocAbout()">
                                    <span class="spinner-border spinner-border-sm d-none" id="doc-about-spinner"></span>
                                    შემდეგი
                                </button>
                            </div>
                        </div>
                    </div>
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
        _fields: String,
    },
    data() {
        return {
            objects: null,
            docs: null,
            fields: null,
            filteredDocs: null,
            showNewCopyButtons: true,
            isNew: false,
            objectId: false,
            docId: false,
            showDocObjects: false,
            showDocumentName: false,
            showUserDocs: false,
            showDocSpinner: false,
            showDocAbout: false,
            showFields: false,
            spinnerTime: 800,
            queryWord: '',
            debouncedTime: null,
            filename: '',
            fieldId: null,
            resetFields: [
                'showNewCopyButtons',
                'showDocObjects',
                'showDocumentName',
                'showDocSpinner',
                'showDocAbout',
                'showFields'
            ],
            docAbout: {
                authorNames: '',
                address: '',
                description: '',
                first_date: '',
                second_date: '',
                number: ''
            },
            docAboutProperties: [],
            breadcrumb: [],
            routes: {},
            current: null,
            shouldGoUpper: false,
            loading: true
        }
    },

    methods: {
        searchDebounced() {
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
            this.breadcrumb.push({
                route: 'objects',
                name: 'ობიექტის არჩევა',
                color: 'text-primary'
            });
            this.current = 'objects';
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
            this.breadcrumb.push({
                route: 'documentName',
                name: 'დოკუმენტის სახელი',
                color: 'text-success'
            });
            this.current = 'documentName';
        },
        nameDocument() {
            if (!this.filename) {
                alert("გთხოვთ, შეიყვანოთ სახელი");
                return;
            }
            this.showDocumentName = false;
            this.showFields = true;
            this.breadcrumb.push({
                route: 'field',
                name: 'სფეროს არჩევა',
                color: 'text-orange'
            });
            this.current = 'field';
        },
        chooseField(id) {
            this.fieldId = id;
            this.showFields = false;
            this.showDocAbout = true;
            this.breadcrumb.push({
                route: 'docAbout',
                name: 'დოკუმენტის შესახებ',
                color: 'text-purple'
            });
            this.current = 'docAbout';
        },
        validateDocAbout() {
            let hasErrors = false;
            this.docAboutProperties.forEach((p, ind) => {
                if (this.docAbout[p.property].length < 1) {
                    this.docAboutProperties[ind].hasError = true;
                    if (!hasErrors) {
                        hasErrors = true;
                    }
                } else {
                    this.docAboutProperties[ind].hasError = false;
                }
            });
            if (!hasErrors) {
                this.createDoc();
            }
        },
        async createDoc() {
            let data = {
                objectId: parseInt(this.objectId),
                filename: this.filename.toString(),
                fieldId: parseInt(this.fieldId),
                _documentAuthorNames: this.docAbout.authorNames,
                _documentAddress: this.docAbout.address,
                _documentDescription: this.docAbout.description,
                _documentFirstDate: this.docAbout.first_date,
                _documentSecondDate: this.docAbout.second_date,
                _documentNumber: this.docAbout.number,
            };

            function start() {
                $('#doc-about-button').addClass('disabled');
                $('#doc-about-spinner').removeClass('d-none');
            }

            function stop() {
                $('#doc-about-button').removeClass('disabled');
                $('#doc-about-spinner').addClass('d-none');
            }

            start();

            if (this.isNew) {
                data['isNew'] = true;

                const res = await httpService.post('/user/docs/prepare-doc', data).catch(err => {
                    alert('სამწუხაროდ შეცდომა დაფიქსირდა. სცადეთ თავიდან');
                    stop();
                });
                if (res) {
                    window.location = '/user/questions';
                }
            } else {
                data['isNew'] = false;
                data['docId'] = parseInt(this.docId);

                const res = await httpService.post('/user/docs/prepare-doc', data).catch(err => {
                    alert('სამწუხაროდ შეცდომა დაფიქსირდა. სცადეთ თავიდან');
                    stop();
                })

                if (res) {
                    window.location = '/user/questions';
                }
            }

            stop();
        },

        initBreadcrumb() {
            this.breadcrumb.push({
                route: 'home',
                name: 'მთავარი',
                color: 'text-danger'
            });

            this.current = 'home';
            this.initRoutes();
        },

        initRoutes() {
            this.routes = {
                home: () => {
                   this.showNewCopyButtons = true;
                },
                objects: () => {
                    this.showDocObjects = true;
                },
                documentName: () => {
                    this.showDocumentName = true;
                },
                field: () => {
                    this.showFields = true;
                }
            }
        },

        resetRoutes() {
            this.resetFields.forEach(field => {
                this[field] = false
            });
        },

        toRoute(route) {
            if (route === this.current) {
                return;
            }

            let index = this.breadcrumb.findIndex(b => b.route === route);
            if (index < 0) {
                return;
            }


            this.resetRoutes();
            this.breadcrumb = this.breadcrumb.slice(0, index + 1);
            this.routes[route]();
        }
    },
    mounted() {
        tout(() => {
            this.loading = false;
            $1('content-spinner').remove()
        });

        this.docAboutProperties = [
            {
                name: '1. შემფასებლის/ების სახელი და გვარი:',
                placeholder: 'სახელი, გვარი',
                property: 'authorNames',
                hasError: false,
            },
            {
                name: ' 2. სამუშაო ობიექტის დასახელება და მისამართი:',
                placeholder: 'დასახელება და მისამართი',
                property: 'address',
                hasError: false,
            },
            {
                name: '3. სამუშაოს მოკლე აღწერა:',
                placeholder: 'აღწერა',
                property: 'description',
                hasError: false,
                rows: 2,
                class: 'hovered-bg',
            },
            {
                name: '4. რისკების შეფასების თარიღი:',
                placeholder: 'თარიღი',
                property: 'first_date',
                hasError: false,
            },
            {
                name: '5. დოკუმენტის გადახედვის სავარაუდო თარიღი:',
                placeholder: 'თარიღი',
                property: 'second_date',
                hasError: false,
            },
            {
                name: '6. დოკუმენტის N:',
                placeholder: 'N: ',
                property: 'number',
                hasError: false,
            }
        ];

        this.docAboutProperties
            .forEach(p => {
                this.$watch(() => this.docAbout[p.property], (a) => {
                    if (a.length < 1) {
                        p.hasError = true;
                    } else {
                        p.hasError = false;
                    }
                })
            });

        this.initBreadcrumb();
        this.shouldGoUpper = window.innerHeight > 800;
    },
    created() {
        this.objects = JSON.parse(this._objects);
        this.docs = JSON.parse(this._docs);
        this.fields = JSON.parse(this._fields);
        // this.showNewCopyButtons = false;
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

.font-size-09-rem {
    font-size: .9rem;
}

.border-bottom-transparent {
    border-bottom: 1px solid transparent !important;
}

.border-transparent {
    border: 1px solid transparent;
}

.hovered-bg:hover {
    background: #f5f4f6;
}

.hovered-bg:focus {
    background: #faf9fc;
}

.underline-on-hover:hover {
    text-decoration: underline;
    cursor: pointer;
}
.go-upper {
    margin-top: -100px;
}
</style>
