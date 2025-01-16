<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";
import { Slider } from "@ckpack/vue-color";
export default {
    name: "Create",
    components: {TaskLayout, Link, 'slider-picker': Slider,},
    props: [
        'errors'
    ],
    data() {
        return {
            title: '',
            color: "#40BFB8",
        }
    },
    methods: {

        store() {
           this.$inertia.post('/labels', {title: this.title, color: this.color.hex})
        },

    }
}

</script>

<template>
    <TaskLayout>
    <div class="w-96 mx-auto pt-5">
        <h1 class="text-lg mb-5 text-center">Добавление Метки</h1>
    <form @submit.prevent="store">
        <div class="mb-6 mb-2 block border-t pt-7 border-gray-300">
        <label class="mb-2 block">Название метки</label>
        <input v-model="title" class="w-full rounded-full border-sky-400" placeholder="Название" type="text">
            <div v-if="errors.title" class="text-red-600 mt-2 ml-3">{{ errors.title }}</div>
            <div class="mt-6"><label>Выберите цвет метки:</label>
            <slider-picker class="mb-5 mt-4" v-model="color" />
                <div v-if="errors.color" class="text-red-600 mt-2 ml-3">{{ errors.color }}</div>
            </div>
        </div>
        <button class="hover:bg-white hover:text-sky-400 border border-sky-400 block py-2 px-4  w-55 ml-auto rounded-full bg-sky-400 text-center text-white" type="submit">Добавить метку</button>
    </form>
    </div>
    </TaskLayout>

</template>

<style scoped>

</style>
