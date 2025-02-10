<template>
    <section class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Головна</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/zoho-crm">Форми</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Створення Угоди</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <form @submit.prevent="submitForm" class="card shadow-sm p-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Створення нової угоди</h5>
            <!-- Block for messages of success or Error -->
            <div v-if="message" :class="['alert', 'alert-dismissible', 'fade', 'show', message.type === 'success' ? 'alert-success' : 'alert-danger']">
                <strong>{{ message.type === 'success' ? 'Успіх!' : 'Помилка!' }}</strong> {{ message.text }}
                <button type="button" class="btn-close" @click="message = null"></button>
            </div>
            <div class="row g-3">
                <!-- Name Deal -->
                <div class="col-6">
                    <label for="name" class="form-label">Назва угоди</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        v-model="name"
                        placeholder="Введіть назву угоди"
                        required
                    >
                </div>

                <!-- Stage Deal -->
                <div class="col-md-6">
                    <label for="stage" class="form-label">Стадія угоди</label>
                    <select
                        class="form-select"
                        id="stage"
                        v-model="stage"
                        required
                    >
                        <option value="" disabled>Оберіть стадію</option>
                        <option value="Qualification" selected>Qualification</option>
                        <option value="Needs Analysis">Needs Analysis</option>
                        <option value="Value Proposition">Value Proposition</option>
                        <option value="Identify Decision Makers">Identify Decision Makers</option>
                        <option value="Proposal/Price Quote">Proposal/Price Quote</option>
                        <option value="Negotiation/Review">Negotiation/Review</option>
                        <option value="Closed Won">Closed Won</option>
                        <option value="Closed Lost">Closed Lost</option>
                        <option value="Closed Lost to Competition">Closed Lost to Competition</option>
                    </select>
                </div>

                <!-- Account Name -->
                <div class="col-md-6">
                    <label for="account_id" class="form-label">Назва аккаунту</label>
                    <select
                        class="form-select"
                        id="account_id"
                        v-model="account_id"
                        required
                    >
                        <option value="" disabled>Оберіть стадію</option>
                        <option>Перший контакт</option>
                        <option>Переговори</option>
                        <option>Узгодження</option>
                        <option>Завершено</option>
                    </select>
                </div>
                <!-- Closing Date  -->
                <div class="col-md-6">
                    <label for="closing_date" class="form-label">Дата закриття</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input
                            type="date"
                            class="form-control"
                            id="closing_date"
                            v-model="closing_date"
                            placeholder="DD.MM.YYYY"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                        <i class="bi bi-file-earmark-plus me-2"></i>
                        {{ loading ? 'Створення...' : 'Створити аккаунт' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            stage: '',
            account_id: '',
            closing_date: '',
        };
    },
    methods: {
        submitForm() {
            axios.post('/api/create-deal', {
                name: this.name,
                stage: this.stage,
                account_id: this.account_id,
                closing_date: this.closing_date,
            }).then(response => {
                alert("Успішно створено!");
            }).catch(error => {
                alert("Помилка: " + error.response.data);
            });
        }
    }
};
</script>

<style scoped>
.card {
    max-width: 550px;
    margin:  100px auto;
    border-radius: 10px;
}

.alert {
    margin-bottom: 15px;
}
</style>
