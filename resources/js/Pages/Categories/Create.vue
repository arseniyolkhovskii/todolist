<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";
export default {
    name: "Create",
    components: {TaskLayout, Link},
    props: [
        'errors'
    ],

    data() {
        return {
            title: '',
        }
    },
    methods: {
        store() {
           this.$inertia.post('/categories', {title: this.title})
        }
    }
}

</script>

<template>
    <TaskLayout>
    <div class="w-96 mx-auto pt-5">
        <h1 class="text-lg mb-5 text-center">Добавление Категории</h1>
    <form @submit.prevent="store">
        <div class="mb-6 mb-2 block border-t pt-7 border-gray-300">
        <label class="mb-2 block">Название категории</label>
        <input v-model="title" class="w-full rounded-full border-sky-400" placeholder="Название" type="text">
            <div v-if="errors.title" class="text-red-600 mt-2 ml-3">{{ errors.title }}</div>
        </div>
        <button class="hover:bg-white hover:text-sky-400 border border-sky-400 block py-2 px-4  w-55 ml-auto rounded-full bg-sky-400 text-center text-white" type="submit">Добавить категорию</button>
    </form>
    </div>
    </TaskLayout>

</template>

<style scoped>

</style>
