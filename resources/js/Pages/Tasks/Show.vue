<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";

export default {
    name: "Index",
    components: {TaskLayout, Link},
    props: {task: Array},
}
</script>

<template>
    <TaskLayout>
        <div class="w-96 mx-auto pt-5">
            <h1 class="text-lg mb-5 text-center">Просмотр задачи</h1>
            <div v-if="task">
                <div class="mt-2 pt-4 border-t border-gray-300" >
                    <div class="text-center text-2xl mb-5 break-words"> {{ task.title }}</div>
                    <div  class="flex items-center mb-1">
                        <span class="text-gray-500 text-sm mr-2 ">Описание:</span>
                        <span v-if="task.description" class="break-words line-clamp-1 text-gray-600">{{ task.description }}</span>
                        <span v-else class="break-words line-clamp-1 text-gray-600">Отсутствует</span>
                    </div>
                    <div class="mb-1"><span class="text-gray-500 text-sm ">Категория: </span><span
                        class="ml-1 text-gray-600"> {{ task.category }}</span></div>
                    <div class="mb-1 text-gray-600"><span class="text-sm  mr-2 text-slate-500">Добавлено:</span><span>{{ task.date }}</span></div>
                    <div class="mb-2 text-gray-600"><span class="text-sm  mr-2 text-slate-500">Последнее редактирование:</span><span>{{ task.updated_date}}</span></div>
                    <div v-if="task.labels && task.labels.length > 0" class="text-gray-600">
                        <span class="text-sm mr-2 text-slate-500">Метки: </span>
                        <span class="" v-for="label in task.labels">
                        <span :style="{ backgroundColor: label.color }" class="py-1 px-2 mb-2 inline-block rounded-full text-white">
                            {{ label.title }}
                        </span>&nbsp;&nbsp;
                    </span>
                    </div>
                    <div class=" text-inline"><span class="text-gray-500 text-sm">Выполнено? </span><span
                        class="ml-1 text-lg">

                      <span :class="task.is_completed == 1 ? 'text-green-500' : 'text-red-600'">
                        {{ task.is_completed == 1 ? 'Да' : 'Нет' }}
                      </span>
                           <span class="text-sm"
                                 v-html="task.is_completed == 1 ? '<i class=\'fas fa-check-circle text-green-500 ml-2\'></i>' : '<i class=\'fa-solid fa-circle-xmark text-red-500 ml-2\'></i>'"></span>
                        </span>
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
        </div>
    </TaskLayout>
</template>

<style scoped>

</style>
