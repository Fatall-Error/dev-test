<template>
    <form @submit.prevent="submitForm" class="card shadow-sm p-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Створення нової угоди</h5>

            <div class="row g-3">
                <!-- Назва угоди -->
                <div class="col-12">
                    <label for="dealName" class="form-label">Назва угоди</label>
                    <input
                        type="text"
                        class="form-control"
                        id="dealName"
                        v-model="dealName"
                        placeholder="Введіть назву угоди"
                        required
                    >
                </div>

                <!-- Стадія угоди -->
                <div class="col-md-6">
                    <label for="dealStage" class="form-label">Стадія угоди</label>
                    <select
                        class="form-select"
                        id="dealStage"
                        v-model="dealStage"
                        required
                    >
                        <option value="" disabled>Оберіть стадію</option>
                        <option>Перший контакт</option>
                        <option>Переговори</option>
                        <option>Узгодження</option>
                        <option>Завершено</option>
                    </select>
                </div>

                <!-- Аккаунт -->
                <div class="col-md-6">
                    <label for="account_id" class="form-label">Аккаунт</label>
                    <input
                        type="text"
                        class="form-control"
                        id="account_id"
                        v-model="account_id"
                        placeholder="Виберіть  аккаунт"
                        required
                    >
                </div>

                <!-- Контактна інформація -->
                <div class="col-md-6">
                    <label for="website" class="form-label">Вебсайт</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                        <input
                            type="text"
                            class="form-control"
                            id="website"
                            v-model="website"
                            placeholder="https://example.com"
                        >
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
                            placeholder="+380 (XX) XXX-XXXX"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-file-earmark-plus me-2"></i>
                        Створити угоду
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
