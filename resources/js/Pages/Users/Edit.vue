<template>
    <div>
        <header class="bg-white shadow mb-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Редактирование пользователя
                </h1>
            </div>
        </header>

        <Link :href="route('users.index')" class="text-indigo-600 hover:text-indigo-900 my-5 block">
            Вернуться назад
        </Link>

        <form @submit.prevent="update">

            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Имя</label>
                            <input :class="{'border-red-500': form.errors.name}" v-model="form.name" type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <div class="text-red-500 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>

                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input :class="{'border-red-500': form.errors.email}" v-model="form.email" type="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <div class="text-red-500 mt-2" v-if="form.errors.email">{{ form.errors.email }}</div>
                        </div>

                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Аватар</label>
                            <input @change="handleAvatarChange" type="file" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <div class="text-red-500 mt-2" v-if="form.errors.avatar">{{ form.errors.avatar }}</div>

                            <!-- Предварительный просмотр аватара при редактировании -->
                            <div class="mt-2" v-if="form.avatarUrl">
                                <img :src="form.avatarUrl" alt="Avatar Preview" class="w-12 h-12 object-cover rounded-full">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button :disabled="form.processing" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Обновить
                    </button>
                </div>

                <div v-if="form.isDirty" class="text-green-500 p-10">
                    Что-то изменилось, не забудьте сохранить форму
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { Link, useForm } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link
    },
    props: {
        user: Object,
    },
    setup(props) {
        const form = useForm({
            name: props.user.name,
            email: props.user.email,
            avatar: null,
            avatarUrl: props.user.avatar_url, // Загрузите URL существующего аватара
        });

        function update() {
            const formData = new FormData();
            formData.append('name', form.name);
            formData.append('email', form.email);
            formData.append('avatar', form.avatar);

            form.put(route('users.update', props.user.id), formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onError: (errors) => {
                    form.errors = errors;
                },
            });
        }

        function handleAvatarChange(event) {
            form.avatar = event.target.files[0];

            const reader = new FileReader();

            reader.onload = (event) => {
                form.avatarUrl = event.target.result;
            };

            reader.readAsDataURL(event.target.files[0]);
        }

        return { form, update, handleAvatarChange };
    },
};
</script>
