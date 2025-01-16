<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";

export default {
    name: "ShowTasks",
    components: {TaskLayout, Link},
    props: {categoryTasks: Array, id: Number},
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
            this.$inertia.get(`/categories/tasks/${this.id}?page=${page}`);
        },
    }
}

</script>

<template>
    <TaskLayout>
        <div class="w-96 mx-auto pt-5">
            <div class="flex items-center justify-center ">
                <span class=" text-gray-500">Список задач с категорией: </span>
            <h1 class="text-xl ml-3 text-center"> {{ categoryTasks.title}}</h1>
            </div>
            <div class="mt-5" v-if="categoryTasks.tasks && categoryTasks.tasks.length > 0">
                <div class="mt-2 pt-4 border-t border-gray-300" v-for="task in categoryTasks.tasks">
                    <div class="text-center text-2xl mb-5 break-words"> {{ task.title }}</div>
                    <div v-if="task.description" class="flex items-center mb-1">
                        <span class="text-gray-500 text-sm mr-2 ">Описание:</span>
                        <span class="break-words line-clamp-1 text-gray-600">{{ task.description }}</span>
                    </div>
                    <div class="mb-1"><span class="text-gray-500 text-sm ">Категория: </span><span
                        class="ml-2 text-gray-600"> {{ task.category }}</span></div>
                    <div class="text-gray-600"><span class="text-sm  mr-2 text-slate-500">Добавлено: </span><span class="">{{ task.date }}</span></div>
                    <div class=" text-inline"><span class="text-gray-500 text-sm">Выполнено? </span><span class="ml-2 text-lg">
                      <span  :class="task.is_completed == 1 ? 'text-green-500' : 'text-red-600'">
                        {{ task.is_completed == 1 ? 'Да' : 'Нет' }}</span>
                           <span class="text-sm" v-html="task.is_completed == 1 ? '<i class=\'fas fa-check-circle text-green-500 ml-2\'></i>' : '<i class=\'fa-solid fa-circle-xmark text-red-500 ml-2\'></i>'"></span>
                    </span>
                    </div>
                    <div class="text-sm text-right">
                        <Link class="hover:text-sky-300 text-sky-500" :href="route('tasks.show', task.id)">Подробнее
                        </Link>
                    </div>
                    <div class="text-sm text-right">
                        <Link class="hover:text-sky-300 text-sky-500" :href="route('tasks.edit', task.id)">
                            Редактировать
                        </Link>
                    </div>
                    <div class="text-sm text-right">
                        <p @click="confirmDelete(task.id)" class="cursor-pointer hover:text-red-400 text-red-600">
                            Удалить</p>
                    </div>
                </div>
            </div>
            <div v-else>
                <h1 class="text-xl text-center mt-5 pt-4 border-t border-gray-300">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i> Задачи с этой категорией отсутствуют!
                </h1>
            </div>
        </div>
        <div v-if="categoryTasks.last_page > 1" class="categoryTasks-wrapper mt-10 flex justify-center">
            <ul class="flex space-x-2">
                <li v-if="categoryTasks.current_page > 1" class="page-item">
                    <a href="#"
                       @click.prevent="fetchPage(categoryTasks.current_page - 1)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium text-gray-700 bg-white border-gray-300 rounded-md hover:bg-gray-50">
                        Предыдущая
                    </a>
                </li>
                <li v-for="page in categoryTasks.last_page"
                    :key="page"
                    :class="{ 'active': page === categoryTasks.current_page }">
                    <a v-if="page !== categoryTasks.current_page" href="#" @click.prevent="fetchPage(page)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md text-blue-500 border-gray-300 hover:bg-gray-50">{{ page }}</a>
                    <span v-else aria-current="page"
                          class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md bg-blue-500 text-white cursor-default">{{ page }}</span>
                </li>
                <li v-if="categoryTasks.current_page < categoryTasks.last_page" class="page-item">
                    <a href="#" @click.prevent="fetchPage(categoryTasks.current_page + 1)"
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

