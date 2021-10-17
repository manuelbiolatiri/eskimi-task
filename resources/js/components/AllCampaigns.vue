<template>
    <div>
        <h2 class="text-center">Campaigns List</h2>
 
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Starts</th>
                <th>Ends</th>
                <th>Daily Budget</th>
                <th>Total Budget</th>
                <th>Number of Images</th>
                <!-- <th>Actions</th> -->
            </tr>
            </thead>
            <tbody>
            <tr v-for="campaign in campaigns" :key="campaign.id">
                <td>{{ campaign.id }}</td>
                <td>{{ campaign.name }}</td>
                <td>{{ campaign.to }}</td>
                <td>{{ campaign.from }}</td>
                <td>{{ campaign.daily_budget }}</td>
                <td>{{ campaign.total_budget }}</td>
                <td>{{ campaign.images.length }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: campaign.id }}" class="btn btn-success">Edit</router-link>
                        <button class="btn btn-danger" @click="deleteCampaign(campaign.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                campaigns: []
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/campaigns/')
                .then(response => {
                    this.campaigns = response.data;
                });
        },
        methods: {
            deleteCampaign(id) { 
                this.axios
                    .delete(`http://localhost:8000/api/campaigns/${id}`)
                    .then(response => {
                        let i = this.campaigns.map(data => data.id).indexOf(id);
                        this.campaigns.splice(i, 1)
                    });
            }
        }
    }
</script>