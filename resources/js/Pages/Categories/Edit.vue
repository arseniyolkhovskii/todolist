<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";
export default {
    name: "Edit",
    components: {TaskLayout, Link},
    props: [
        'category',
        'errors'
    ],

    data() {
        return {
            id: this.category.id,
            title: this.category.title,
        }
    },
    methods: {
        update() {
           this.$inertia.patch(`/categories/${this.id}`, {title: this.category.title})
        }
    }
}

</script>

<template>
    <TaskLayout>
    <div class="w-96 mx-auto pt-5">
        <h1 class="text-lg mb-5">Редактирование Категории</h1>
    <form @submit.prevent="update">
        <div class="mb-6 mb-2 block border-t pt-7 border-gray-300">
        <label class="mb-2 block">Название категории</label>
        <input v-model="category.title" class="w-full rounded-full border-sky-400" type="text">
            <div v-if="errors.title" class="text-red-600 mt-2 ml-3">{{ errors.title }}</div>
        </div>
        <button class="hover:bg-white hover:text-sky-400 border border-sky-400 block py-2 px-4  w-55 ml-auto rounded-full bg-sky-400 text-center text-white" type="submit">Обновить категорию</button>
    </form>
    </div>
    </TaskLayout>
</template>

<style scoped>

</style>
