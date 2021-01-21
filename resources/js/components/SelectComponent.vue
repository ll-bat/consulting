<template>
    <div class="position-relative" :class="{'index-1': expanded}" style="padding-bottom: 50px;">
        <div class="position-absolute">
            <div class="select m-0" @click="expand($event)" :class="{'border scrollable select-shadow': expanded}" style="width: 350px">
                <p class="title border pointer overflow-hidden position-relative rounded-0" :id="id"
                   :class="{'d-none' : expanded}"
                   style="width: 95%;max-height: 60px"> {{ selected ? selected.name : title }}
                    <i class="fa fa-caret-down float-right px-3 py-1" style="vertical-align: middle"></i>
                </p>

                <div class="options" :class="{'d-none': !expanded, 'my-2' : expanded}">
                    <p class="option"  @click="select(defaultValue)">{{title}}</p>
                    <p v-for="(option , index) in options" class="option" :class="{'selected': index === selected.index}" @click="select({...option, index})"> {{ option.name }}</p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: {
        data: Array,
        title: String,
        setDefault: {
            default: false,
        },
        id: {
            default: get_uuid()
        },
        selectEvent: {
            type: String,
            default: false,
        }
    },
    data() {
        return {
            options: null,
            expanded: false,
            selected: false,
            defaultValue: {id: -1, name: this.title, index: -1}
        }
    },
    watch: {
        data: function () {
            this.refresh()
        },
    },
    methods: {
        expand(ev) {
            this.expanded = !this.expanded

            if (this.expanded) {
                Event.$emit('collapse', this.id)
            }

        },
        select(option){
            this.selected = option
            this.$emit('select', option.value)
        },
        refresh(){
            this.options = JSON.parse(JSON.stringify(this.data))
        },
        setDefaultValue() {
            this.selected = this.defaultValue;
        },
    },
    created() {
        tout(() => {
            if (this.options === null) {
                this.refresh()
            }
        })

        Event.$on('collapse', (id) => {
            if (this.id !== id) {
                this.expanded = false;
            }
        })

        if (this.setDefault) {
            Event.$on('setDefaultValue', () => {
                this.setDefaultValue()
            })
        }

        if (this.selectEvent) {
            Event.$on(this.selectEvent, (id) => {
                let option = null;
                for (let i=0; i<this.options.length; i++) {
                    if (this.options[i].value === id) {
                        option = {...this.options[i], index: i};
                        break;
                    }
                }
                if (option) {
                    this.selected = option;
                } else {
                    throw new Error('No such element found');
                }
            })
        }

    }
}
</script>

<style>
.select {
    background: white;
    max-height: 400px;
}

.scrollable {
    overflow-y: scroll;
}

.index-1 {
    z-index: 1 !important;
}

.index-2 {
    z-index: 2 !important;
}

.index-3 {
    z-index: 3 !important;
}

.border {
    border: 1px solid lightgrey;
    border-radius: 6px;
}

.select-rounded {
    border-radius: 6px !important;
}

.select-shadow {
    box-shadow: 0 0 5px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1);
}

.title {
    color: rgba(0, 0, 0, .8);
    font-weight: lighter;
    padding: 8px 15px;
    padding-right: 5px;
}

.option {
    padding: 10px 20px;
    margin: 0;
    cursor: pointer;
}

.option:hover {
    background: lightgrey;
}

.selected {
    background: rgba(0,0,0,.04);
}

::-webkit-scrollbar {
    width: 7px;
}

/* Track */
::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px lightgrey;
    border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: lightgrey;
    border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
}
</style>
