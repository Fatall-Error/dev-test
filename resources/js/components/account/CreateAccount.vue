<template>
    <form @submit.prevent="submitForm">
        <input type="text" v-model="name" placeholder="Назва угоди" required />
        <input type="text" v-model="stage" placeholder="Стадія угоди" required />
        <input type="text" v-model="account_id" placeholder="Назва компанії" required />
        <input type="text" v-model="website" placeholder="Вебсайт" />
        <input type="text" v-model="phone" placeholder="Телефон" />
        <button type="submit">Створити угоду</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            stage: '',
            account_id: '',
            website: '',
            phone: '',
        };
    },
    methods: {
        submitForm() {
            axios.post('/api/create-deal', {
                name: this.name,
                stage: this.stage,
                account_id: this.account_id,
                website: this.website,
                phone: this.phone,
            }).then(response => {
                alert("Успішно створено!");
            }).catch(error => {
                alert("Помилка: " + error.response.data);
            });
        }
    }
};
</script>
