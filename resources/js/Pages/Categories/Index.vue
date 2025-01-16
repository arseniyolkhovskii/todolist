<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";

export default {
    name: "Index",
    components: {TaskLayout, Link},
    props: {categories: Array, pagination: Object,},
    methods: {
        deleteCategory(id) {
            this.$inertia.delete(`/categories/${id}`)
        },
        confirmDelete(id) {
            if (confirm('Вы уверены, что хотите удалить эту категорию? Все связанные задачи также удалятся')) {
                this.deleteCategory(id);
            }
        },
        fetchPage(page) {
            this.$inertia.get('/categories', {page: page});
        },
    }
}

</script>

<template>
    <TaskLayout>
        <div class="w-96 mx-auto pt-5">
            <div class="flex items-center justify-between">
            <h1 class="text-lg  text-center">Список категорий</h1>
                <Link :href="route('categories.create')" class="px-3 py-1 hover:bg-white hover:text-sky-400 border border-sky-400 rounded-full bg-sky-400 text-center text-white">Добавить категорию</Link>
            </div>
            <div class="mt-5" v-if="categories && categories.length > 0">
                <div class="mt-2 pt-4 border-t border-gray-300" v-for="category in categories">
                    <div class="text-center text-2xl mb-5"> {{ category.title }}</div>
                        <div class="flex justify-between mb-1 text-sm text-right">
                                <Link class="hover:text-sky-300  text-sky-500" :href="route('categories.show', category.id)" >
                                    Подробнее...
                                </Link>
                        <Link class="hover:text-sky-300 text-sky-500" :href="route('categories.edit', category.id)">
                            Редактировать
                        </Link>
                    </div>
                <div class="flex justify-between mb-3 text-sm text-right">
                        <Link class="hover:text-sky-300  text-sky-500" :href="route('categories.showTasks', category.id)" >
                            Задачи с этой категорией
                        </Link>
                        <p @click="confirmDelete(category.id)" class="cursor-pointer hover:text-red-400 text-red-600">
                            Удалить</p>
                </div>
                </div>
            </div>
            <div v-else>
                <h1 class="text-xl text-center mt-5 pt-4 border-t border-gray-300">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i> Пока что нет ни одной категории!
                </h1>
            </div>
        </div>
        <div v-if="pagination.last_page > 1" class="pagination-wrapper mb-10 mt-10 flex justify-center">
            <ul class="flex space-x-2">
                <li v-if="pagination.current_page > 1" class="page-item">
                    <a href="#"
                       @click.prevent="fetchPage(pagination.current_page - 1)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium text-gray-700 bg-white border-gray-300 rounded-md hover:bg-gray-50">
                        Предыдущая
                    </a>
                </li>
                <li v-for="page in pagination.last_page"
                    :key="page"
                    :class="{ 'active': page === pagination.current_page }">
                    <a v-if="page !== pagination.current_page" href="#" @click.prevent="fetchPage(page)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md text-blue-500 border-gray-300 hover:bg-gray-50">{{ page }}</a>
                    <span v-else aria-current="page"
                          class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md bg-blue-500 text-white cursor-default">{{ page }}</span>
                </li>
                <li v-if="pagination.current_page < pagination.last_page" class="page-item">
                    <a href="#" @click.prevent="fetchPage(pagination.current_page + 1)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium text-gray-700 bg-white border-gray-300 rounded-md hover:bg-gray-50">
                        Следующая
                    </a>
                </li>
            </ul>
        </div>
    </TaskLayout>
</template>

<style scoped>

</style>

