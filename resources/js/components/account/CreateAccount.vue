<template>
    <form @submit.prevent="submitForm" class="card shadow-sm p-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Створення нового аккаунту</h5>

            <div class="row g-3">
                <!-- Name account -->
                <div class="col-12">
                    <label for="name" class="form-label">Назва аккаунту</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        v-model="name"
                        placeholder="Введіть назву аккаунту"
                        required
                    >
                </div>

                <!-- Website -->
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
                        Створити аккаунт
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
            owner_id: '',
            account_id: '',
            website: '',
            phone: '',
        };
    },
    methods: {
        submitForm() {
            axios.post('/api/create-account', {
                owner_id: this.owner_id,
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
