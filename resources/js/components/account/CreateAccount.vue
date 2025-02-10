<template>
    <form @submit.prevent="submitForm" class="card shadow-sm p-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Створення нового аккаунту</h5>

            <div v-if="message" :class="message.type" class="alert alert-dismissible fade show">
                <strong>{{ message.type === 'success' ? 'Успіх!' : 'Помилка!' }}</strong> {{ message.text }}
                <button type="button" class="btn-close" @click="message = null"></button>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <label for="name" class="form-label">Назва аккаунту</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        v-model="name"
                        :class="{'is-invalid': errors.name}"
                        placeholder="Введіть назву аккаунту"
                        required
                    >
                    <div v-if="errors.name" class="invalid-feedback">
                        {{ errors.name[0] }}
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="website" class="form-label">Вебсайт</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                        <input
                            type="text"
                            class="form-control"
                            id="website"
                            v-model="website"
                            :class="{'is-invalid': errors.website}"
                            placeholder="https://example.com"
                        >
                        <div v-if="errors.website" class="invalid-feedback">
                            {{ errors.website[0] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Телефон</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input
                            type="tel"
                            class="form-control"
                            id="phone"
                            v-model="phone"
                            :class="{'is-invalid': errors.phone}"
                            placeholder="+380 (XX) XXX-XXXX"
                        >
                        <div v-if="errors.phone" class="invalid-feedback">
                            {{ errors.phone[0] }}
                        </div>
                    </div>
                </div>
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
            website: '',
            phone: '',
            errors: {},
            loading: false,
            message: null
        };
    },
    methods: {
        async submitForm() {
            this.errors = {};
            this.loading = true;
            this.message = null;

            try {
                await axios.post('/api/create-account', {
                    name: this.name,
                    website: this.website,
                    phone: this.phone,
                });

                this.message = {
                    type: 'success',
                    text: 'Аккаунт успішно створено!'
                };
                this.resetForm();

            } catch (error) {
                if (error.response && error.response.status === 422) {
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
            this.website = '';
            this.phone = '';
            this.errors = {};
        }
    }
};
</script>

<style scoped>
.card {
    max-width: 550px;
    margin: auto;
    border-radius: 10px;
}

.alert {
    margin-bottom: 15px;
}
</style>
