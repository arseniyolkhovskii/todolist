<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";

export default {
    name: "ShowTasks",
    components: {TaskLayout, Link},
    props: {labelTasks: Object, id: Number,},
    methods: {
        deleteTask(id) {
            this.$inertia.delete(`/tasks/${id}`)
        },
        confirmDelete(id) {
            console.log(this.id);
            if (confirm('Вы уверены, что хотите удалить эту задачу?')) {
                this.deleteTask(id);
            }
        },
        fetchPage(page) {

            this.$inertia.get(`/labels/tasks/${this.id}?page=${page}`);
        },
    }
}

</script>

<template>
    <TaskLayout>
        <div class="w-96 mx-auto pt-4">
            <div class="flex items-center justify-center ">
                <span class=" text-gray-500">Список задач с меткой: </span>
            <h1 class="text-xl ml-3 text-center"><span :style="{ backgroundColor: labelTasks.color }" class="py-1 px-3 rounded-3xl inline-block  text-white"> {{ labelTasks.title}}</span></h1>
            </div>
            <div class="mt-4" v-if="labelTasks.tasks && labelTasks.tasks.length > 0">
                <div class="mt-2 pt-4 border-t border-gray-300" v-for="task in labelTasks.tasks">
                    <div class="text-center text-2xl mb-5 break-words"> {{ task.title }}</div>
                    <div class=" text-inline"><span class="text-gray-500 text-sm">Выполнено? </span><span class="ml-2 text-lg">
                      <span  :class="task.is_completed == 1 ? 'text-green-500' : 'text-red-600'">
                        {{ task.is_completed == 1 ? 'Да' : 'Нет' }}</span>
                           <span class="text-sm" v-html="task.is_completed == 1 ? '<i class=\'fas fa-check-circle text-green-500 ml-2\'></i>' : '<i class=\'fa-solid fa-circle-xmark text-red-500 ml-2\'></i>'"></span>
                    </span>
                    </div>
                    <div class="text-sm text-right mt-5">
                        <Link class="hover:text-sky-300 text-sky-500" :href="route('tasks.edit', task.id)">
                            Редактировать
                        </Link>
                    <div class="flex justify-between">
                        <Link class="hover:text-sky-300 text-sky-500" :href="route('tasks.show', task.id)">Подробнее...
                        </Link>
                        <p @click="confirmDelete(task.id)" class="cursor-pointer hover:text-red-400 text-red-600">
                            Удалить</p>
                    </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <h1 class="text-xl text-center mt-5 pt-4 border-t border-gray-300">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i> Задачи с этой меткой отсутствуют!
                </h1>
            </div>
        </div>
        <div v-if="labelTasks.last_page > 1" class="pagination-wrapper mb-10 mt-10 flex justify-center">
            <ul class="flex space-x-2">
                <li v-if="labelTasks.current_page > 1" class="page-item">
                    <a href="#"
                       @click.prevent="fetchPage(labelTasks.current_page - 1)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium text-gray-700 bg-white border-gray-300 rounded-md hover:bg-gray-50">
                        Предыдущая
                    </a>
                </li>
                <li v-for="page in labelTasks.last_page"
                    :key="page"
                    :class="{ 'active': page === labelTasks.current_page }">
                    <a v-if="page !== labelTasks.current_page" href="#" @click.prevent="fetchPage(page)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md text-blue-500 border-gray-300 hover:bg-gray-50">{{ page }}</a>
                    <span v-else aria-current="page"
                          class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md bg-blue-500 text-white cursor-default">{{ page }}</span>
                </li>
                <li v-if="labelTasks.current_page < labelTasks.last_page" class="page-item">
                    <a href="#" @click.prevent="fetchPage(labelTasks.current_page + 1)"
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

