<template>
    <div>
        <h3 class="text-center">Create Campaign</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCampaign">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text"  class="form-control" v-model="campaign.name" required>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date"  class="form-control" v-model="campaign.from" required>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" class="form-control" v-model="campaign.to" required>
                    </div>
                     <div class="form-group">
                        <label>Daily Budget</label>
                        <input type="number" class="form-control" v-model="campaign.daily_budget" required>
                    </div>
                     <div class="form-group">
                        <label>Total Budget</label>
                        <input type="number" class="form-control" v-model="campaign.total_budget" required>
                    </div>
                    <reusable-button :config="{'class': 'btn-primary','text':'Create','type':'submit'}"></reusable-button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    import ReusableButton from './Button.vue';
    export default {
        data() {
            return {
                campaign: {}
            }
        },
        components:{
            ReusableButton
        },
        methods: {
            addCampaign() {
                this.axios
                    .post('http://localhost:8000/api/campaigns', this.campaign)
                    .then(response => (
                        this.$router.push({ name: 'home' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>