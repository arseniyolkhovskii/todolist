<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";

export default {
    name: "Index",
    components: {TaskLayout, Link},
    props: {pagination: Object, labels: Array, tasks: Array},
    methods: {
        deleteTask(id) {
            this.$inertia.delete(`/tasks/${id}`)
        },
        confirmDelete(id) {
            if (confirm('Вы уверены, что хотите удалить эту задачу?')) {
                this.deleteTask(id);
            }
        },
        fetchPage(page) {
            this.$inertia.get('/', {page: page});
        },
    },
}
</script>

<template>
    <TaskLayout>
        <div class="flex justify-center ">
            <div v-if="labels && labels.length > 0" class="fixed w-32 left-96 mt-10 ml-40">
        <span class="" v-for="label in labels">
            <Link :href="route('labels.showTasks', label.id)" :style="{ backgroundColor: label.color }"
                  class="block text-center py-2 rounded-3xl mb-5 text-white">
                {{ label.title }}
            </Link>
        </span>
            </div>
            <div class="w-96 pt-5">
                <h1 class="text-lg mb-5 text-center">Список задач</h1>
                <div v-if="tasks && tasks.length > 0">
                    <div class="mt-2 pt-4 border-t border-gray-300" v-for="task in tasks">
                        <div class="text-center text-2xl mb-5 break-words"> {{ task.title }}</div>


                        <div class="mb-2 text-inline">
                            <span class="text-gray-500 text-sm">Выполнено? </span>
                            <span class="ml-2 text-lg">
                        <span :class="task.is_completed == 1 ? 'text-green-500' : 'text-red-600'">
                            {{ task.is_completed == 1 ? 'Да' : 'Нет' }}
                        </span>
                        <span class="text-sm"
                              v-html="task.is_completed == 1 ? '<i class=\'fas fa-check-circle text-green-500 ml-2\'></i>' : '<i class=\'fa-solid fa-circle-xmark text-red-500 ml-2\'></i>'"></span>
                    </span>
                        </div>
                    <div v-if="task.labels && task.labels.length > 0" class="text-gray-600">
                        <span class="text-sm mr-2 text-slate-500">Метки: </span>
                        <span class="" v-for="label in task.labels">
                        <span :style="{ backgroundColor: label.color }" class="py-1 px-2 mb-2 text-sm inline-block rounded-full text-white">
                            {{ label.title }}
                        </span>&nbsp;&nbsp;
                    </span>
                    </div>
                        <div class="mt-8 text-sm text-right">
                            <Link class="hover:text-sky-300 text-sky-500" :href="route('tasks.edit', task.id)">
                                Редактировать
                            </Link>
                        </div>
                        <div class="flex justify-between">
                            <div class="text-sm text-right">
                                <Link class="hover:text-sky-300 text-sky-500" :href="route('tasks.show', task.id)">
                                    Подробнее...
                                </Link>
                            </div>
                        <div class="text-sm text-right">
                            <p @click="confirmDelete(task.id)" class="cursor-pointer hover:text-red-400 text-red-600">
                                Удалить</p>
                        </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <h1 class="text-xl text-center mt-2 pt-4 border-t border-gray-300">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Все задачи выполнены!
                    </h1>
                </div>
            </div>
        </div>
        <div v-if="pagination.last_page > 1" class="pagination-wrapper mb-5 mt-10 flex justify-center">
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
html {
    scroll-behavior: smooth;
}
</style>
