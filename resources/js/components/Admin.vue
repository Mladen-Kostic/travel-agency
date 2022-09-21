<template>
    <div>
        <h1 class="mb-4 pb-2 H1"><i class="fas fa-user-cog"></i> Admin</h1>
        
        <div class="container">
            <h3><i class="fas fa-user-shield"></i> The Insured</h3>
            <table v-if="travelInsurances" class="table mr-2">
                <thead>
                    <tr>
                    <!-- <th scope="col">ID</th> -->
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">More</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in travelInsurances" :key="item.id">
                        <!-- <td>{{ item.id }}</td> -->
                        <td>{{ item.first_name }}</td>
                        <td>{{ item.last_name }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.phone }}</td>
                        <td>{{ formatDate(item.dob) }}</td>
                        <td>
                            <div class="dropdown show">
                            <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ...
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item bg-transparent">Departure:&nbsp;{{ formatDate(item.departure) }}</a>
                                <a class="dropdown-item bg-transparent">Return:&nbsp;{{ formatDate(item.return) }}</a>
                                <a class="dropdown-item bg-transparent">From:&nbsp;{{ item.from }}</a>
                                <a class="dropdown-item bg-transparent">To:&nbsp;{{ item.to }}</a>
                                <a class="dropdown-item bg-transparent" href="#"><button class="btn btn-primary">Group Insurance</button></a>
                            </div>
                            </div>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <div class="text-center pt-5" v-else>
                <h3>Could not find any Insurances...</h3>
                <h3>¯\_(ツ)_/¯</h3>
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            travelInsurances: null
        }
    },
    methods: {
        formatDate(d) {
            const date = new Date(d);

            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}.${month}.${year}`;
        }
    },
    mounted() {
        
        axios.get('/travel-insurance/admin/show-travel-insurances')
            // .then((res) => console.log(res.data[0].dob))
            .then((res) => {
                this.travelInsurances = res.data;
            })
            .catch((error) => console.log(error));
    }
}
</script>

<style>
.table {
    color: #fff;
    background-color: #1976d27c;
    padding: 2rem 2rem 4rem 2rem;
    border-radius: 0.7rem;
}
.table td {
    border-top: 1px solid rgba(255, 255, 255, 0.295);
}
.table th {
    border: none;
}

.H1 {
    border-bottom: 1px solid rgba(255, 255, 255, 0.295);
}

.dropdown-menu {
    background-color: #1976d27c;
    color: #fff;
}

</style>

