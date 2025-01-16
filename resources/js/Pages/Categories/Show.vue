<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";

export default {
    name: "Index",
    components: {TaskLayout, Link},
    props: {category: Array,},
    methods: {
        deleteCategory(id) {
            this.$inertia.delete(`/categories/${id}`)
        },
        confirmDelete(id) {
            if (confirm('Вы уверены, что хотите удалить эту категорию? Все связанные задачи также удалятся')) {
                this.deleteCategory(id);
            }
        },

    }
}

</script>

<template>
    <TaskLayout>
        <div class="w-96 mx-auto pt-5">
            <div class="flex items-center justify-between">
            <h1 class="text-lg  text-center">Категория </h1>
                <Link :href="route('categories.create')" class="px-3 py-1 hover:bg-white hover:text-sky-400 border border-sky-400 rounded-full bg-sky-400 text-center text-white">Добавить категорию</Link>
            </div>
            <div class="mt-5">
                <div class="mt-2 pt-4 border-t border-gray-300" >
                    <div class="text-center text-2xl mb-5"> {{ category.title }}</div>
                    <div><span class="text-sm  mr-2 text-slate-500">ID:</span><span
                        class="text-sm text-gray-700">{{ category.id }}</span></div>
                    <div><span class="text-sm  mr-2 text-slate-500">Добавлено:</span><span
                        class="text-sm text-gray-700">{{ category.date }}</span></div>
                    <div class="mb-5"><span class="text-sm  mr-2 text-slate-500">Последнее редактирование:</span><span
                        class="text-sm text-gray-700">{{ category.updated_date }}</span></div>
                    <div class="text-sm text-right">
                        <Link class="hover:text-sky-300 text-sky-500" :href="route('categories.edit', category.id)">
                            Редактировать
                        </Link>
                    </div>
                <div class="flex justify-between mb-3">
                    <div class="text-sm text-right">
                        <Link class="hover:text-sky-300  text-sky-500" :href="route('categories.showTasks', category.id)" >
                            Задачи с этой категорией
                        </Link>
                    </div>
                    <div class="text-sm text-right">
                        <p @click="confirmDelete(category.id)" class="cursor-pointer hover:text-red-400 text-red-600">
                            Удалить</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </TaskLayout>
</template>

<style scoped>

</style>

