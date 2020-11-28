<template>
    <div class="position-relative mb-5" :class="{'index-1': expanded}">
        <div class="position-absolute">
            <div class="select m-0" @click="expand($event)" :class="{'border scrollable select-shadow': expanded}" style="width: 350px">
                <p class="title border pointer" :class="{'d-none' : expanded}" style="width: 100%"> {{ selected ? selected.name : title }}
                    <i class="fa fa-caret-down float-right px-3 py-1"></i>
                </p>
                <div class="options" :class="{'d-none': !expanded, 'my-2' : expanded}">
                    <p class="option"  @click="select({id: -1, name: title, index: -1})">{{title}}</p>
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
        id: {
            default: get_uuid()
        }
    },
    data() {
        return {
            options: null,
            expanded: false,
            selected: false,
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

        },
        select(option){
            this.selected = option
            this.$emit('select', option.value)
        },
        refresh(){
            this.options = JSON.parse(JSON.stringify(this.data))
        }
    },
    created() {
        tout(() => {
            if (this.options === null) {
                this.refresh()
            }
        })
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
    z-index: 1;
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
