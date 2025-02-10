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
            <div v-if="message"
                 :class="['alert', 'alert-dismissible', 'fade', 'show', message.type === 'success' ? 'alert-success' : 'alert-danger']">
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
                        :class="{'is-invalid': errors.name}"
                        placeholder="Введіть назву угоди"
                    >
                    <div v-if="errors.name" class="invalid-feedback">
                        {{ errors.name[0] }}
                    </div>
                </div>

                <!-- Stage Deal -->
                <div class="col-md-6">
                    <label for="stage" class="form-label">Стадія угоди</label>
                    <select
                        class="form-select"
                        id="stage"
                        v-model="stage"
                        :class="{'is-invalid': errors.stage}"
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
                    <div v-if="errors.stage" class="invalid-feedback">
                        {{ errors.stage[0] }}
                    </div>
                </div>

                <!-- Account Name -->
                <div class="col-md-6">
                    <label for="account_id" class="form-label">Назва аккаунту</label>
                    <select class="form-select" id="account_id" v-model="account_id"
                            :class="{'is-invalid': errors.account_id}" >
                        <option value="" disabled>Оберіть аккаунт</option>
                        <option v-for="account in accounts" :key="account.id" :value="account.id">
                            {{ account.Account_Name }}
                        </option>
                    </select>
                    <div v-if="errors.account_id" class="invalid-feedback">
                        {{ errors.account_id[0] }}
                    </div>
                </div>
                <!-- Closing Date  -->
                <div class="col-md-6">
                    <label for="closing_date" class="form-label">Дата закриття</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input
                            type="date"
                            class="form-control"
                            id="closing_date"
                            v-model="closing_date"
                            :class="{'is-invalid': errors.closing_date}"
                            placeholder="DD.MM.YYYY"
                        >
                        <div v-if="errors.closing_date" class="invalid-feedback">
                            {{ errors.closing_date[0] }}
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                        <i class="bi bi-file-earmark-plus me-2"></i>
                        {{ loading ? 'Створення...' : 'Створити Угоду' }}
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
            errors: {},
            loading: false,
            message: null,
            accounts: [],
        };
    },
    methods: {
        async fetchAccounts() {
            try {
                let response = await axios.get('/api/accounts');
                this.accounts = response.data.data;
            } catch (error) {
                console.error('Помилка отримання акаунтів:', error);
            }
        },
        async submitForm() {
            this.errors = {};
            this.loading = true;
            this.message = null;

            try {
                const response = await axios.post('/api/create-deal', {
                    name: this.name,
                    stage: this.stage,
                    account_id: this.account_id,
                    closing_date: this.closing_date,
                });

                if (response.data && response.data.status && response.data.status === 'error') {
                    this.message = {
                        type: 'error',
                        text: response.data.message || 'Помилка створення угоди.'
                    };
                } else {
                    this.message = {
                        type: 'success',
                        text: 'Угоду успішно створено!'
                    };
                    this.resetForm();
                }

            } catch (error) {

                if (error.response.code === 'AUTHENTICATION_FAILURE') {
                    this.message = {
                        type: 'error',
                        text: 'Помилка аутентифікації: ' + error.response.message
                    };
                } else if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    this.message = {
                        type: 'error',
                        text: "Сталася помилка: " + error.message
                    };
                }
            }
            this.loading = false;
        },

        resetForm() {
            this.name = '';
            this.stage = '';
            this.account_id = '';
            this.closing_date = '';
            this.errors = {};
        }
    },
    mounted() {
        this.fetchAccounts();
    }
};
</script>

<style scoped>
.card {
    max-width: 550px;
    margin: 100px auto;
    border-radius: 10px;
}

.alert {
    margin-bottom: 15px;
}
</style>
