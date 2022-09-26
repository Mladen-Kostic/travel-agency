<template>
    <div>
        <h1 class="mb-4 pb-2 H1"><i class="fas fa-user-cog"></i> Admin</h1>
        
        <div class="container">
            <h3><i class="fas fa-user-shield"></i> Insured</h3>
            <div class="tableResponsive">
            <table v-if="travelInsurances" class="table mr-2">
                
                <thead>
                    <tr>
                    <!-- <th scope="col">ID</th> -->
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Date Of Birth</th>
                    <th scope="col">Group Insurance</th>
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
                        <td v-if="item.group">

                            <!-- Button trigger modal -->
                            <button @click="showGroupInsured(item.id)" type="button" class="btn btn-primary bg-transparent" data-toggle="modal" data-target="#exampleModal">
                                See All
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Group Insurance</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Date Of Birth</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="groupItem in groupInsurances" :key="groupItem.id">
                                            <td>{{ groupItem.first_name }}</td>
                                            <td>{{ groupItem.last_name }}</td>
                                            <td>{{ groupItem.dob }}</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>

                        </td>
                        <td v-else>Individual</td>
                        <td>
                            <div class="dropdown show">
                                <a class="btn btn-primary dropdown-toggle bg-transparent dropdownBorder" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Show more information about the Insured.">
                                    ...
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item bg-transparent">Departure:&nbsp;{{ formatDate(item.departure) }}</a>
                                    <a class="dropdown-item bg-transparent">Return:&nbsp;{{ formatDate(item.return) }}</a>
                                    <a class="dropdown-item bg-transparent">From:&nbsp;{{ item.from }}</a>
                                    <a class="dropdown-item bg-transparent">To:&nbsp;{{ item.to }}</a>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            travelInsurances: null,
            groupInsurances: null,
        }
    },
    methods: {
        formatDate(d) {
            const date = new Date(d);

            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}.${month}.${year}`;
        },
        showGroupInsured(id) {
            axios.get('/group/' + id)
                // .then((res) => console.log(res))
                .then((res) => {
                    this.groupInsurances = res.data;
                })
                .catch((error) => console.log(error));
        }
    },
    mounted() {
        
        axios.get('/travel-insurance/admin/show-travel-insurances')
            // .then((res) => console.log(res.data[0].dob))
            .then((res) => {
                if (res.data) {
                    this.travelInsurances = res.data;
                } else {
                    this.travelInsurances = false;
                }

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
    border-radius: 0.4rem;
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
    background-color: #1976d2ce;
    color: #fff;
}

.modal-backdrop {
   background-color: #1976d27c;
}

.modal-content {
   color: black;
}

.tableResponsive {
    display: block;
    width: 100%;
    
    -webkit-overflow-scrolling: touch;
}

.dropdownBorder {
    border-color:#fff!important;
}

@media (max-width: 800px) {
    .tableResponsive {
        overflow-x: auto;
    }
}
</style>

