<template>
    <div id="travelInsurance">
        <h1 class="mb-4"><i class="fas fa-user-shield"></i> Travel Insurance</h1>
        <div id="toggle" class="pt-4">
            <h4 :class="[{'textOpacity': group}, d_inline_block]">Individual Insurance</h4>

            <label class="switch mx-3">
            <input @click="this.changeOpacity" type="checkbox">
            <span class="slider round"></span>
            </label>

            <h4 :class="[{'textOpacity': individual}, d_inline_block]">Group Insurance</h4>
        </div>
        
        <form id="travelInsuranceForm" @submit.prevent="makeInsurance">

            <input v-if="group" type="hidden" name="group" value="1">
            <div class="form-group row ml-2">
                <div class="row col-6 groupForm">
                    <div class="col-12">
                        <label for="departure">Departure&nbsp;Date</label>
                        <Datepicker
                            v-model="departureDate"
                            placeholder="Departure date"
                            name="departure"
                            id="departure"
                            :minDate="departureStartDate"
                            :format="formatTime"
                        ></Datepicker>
                        <div v-if="invalidDeparture" class="invalid-feedback-alt text-right">
                            Departure date is mandatory.
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label for="return">Return&nbsp;Date</label>
                        <Datepicker
                            v-model="returnDate"
                            placeholder="Return date"
                            name="return"
                            id="return"
                            :minDate="departureDate"
                            :format="formatTime"
                        ></Datepicker>
                        <div v-if="invalidReturn" class="invalid-feedback-alt text-right">
                            Return date is mandatory.
                        </div>
                    </div>
                    <div v-if="departureDate && returnDate" class="px-3">
                        Total Travel Days: {{ getVacationLength }}
                    </div>
                </div>
                <div class="row col-6 ml-4 groupForm">
                    <div class="col-12">
                        <label for="from">Travel&nbsp;From</label>
                        <input name="from" type="text" class="form-control" id="from">
                        <div class="invalid-feedback text-right">
                            Travel From field is mandatory.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="to">Travel&nbsp;To</label>
                        <input name="to" type="text" class="form-control" id="to">
                        <div class="invalid-feedback text-right">
                            Travel To field is mandatory.
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="first_name">First Name</label>
                    <input name="first_name" type="text" class="form-control" id="first_name" placeholder="First Name">
                    <div class="invalid-feedback text-right">
                        First Name field is mandatory.
                    </div>
                </div>
                <div class="col-6">
                    <label for="last_name">Last Name</label>
                    <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Last Name">
                    <div class="invalid-feedback text-right">
                        Last Name field is mandatory.
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="email">Email Address</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="Email Address">
                    <div class="invalid-feedback text-right">
                        Email Addres field is mandatory.
                    </div>
                </div>
                <div class="col-6">
                    <label for="phone">Phone Number</label>
                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Phone Number">
                    <div class="invalid-feedback text-right">
                        Phone Number field is mandatory.
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="last_name">Date of Birth</label>
                <Datepicker
                    v-model="birthDate"
                    placeholder="Date Of Birth"
                    name="dob"
                    :format="format"
                ></Datepicker>
                <div v-if="invalidDob" class="invalid-feedback-alt text-right">
                    Date of Birth field is mandatory.
                </div>
            </div>
            <Transition>
            <div v-if="group">
                <GroupInsurance @addToGroupList="(obj) => groupInsuranceList.push(obj)" />

                <div v-for="item in groupInsuranceList" :key="item.id" class="form-group row groupInsuranceItem">
                    <div class="col-3">{{ item.first_name }}</div>
                    <div class="col-3">{{ item.last_name }}</div>
                    <div class="col-3">{{ item.dob }}</div>
                    <div class="col-3">
                        <a @click="removeItem(item)" class="btn btn-secondary trashBtn btn-block"><i class="fas fa-trash-alt"></i> Remove</a>
                    </div>
                </div>
                
                <!-- <div v-if="groupInsuranceList.length" class="dropdown show row">
                    <a class="btn btn-secondary btn-block dropdown-toggle col-9" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Check List
                    </a>
                    <div class="col-3">
                        <a @click="removeItem(item)" class="btn btn-secondary trashBtn btn-block"><i class="fas fa-trash-alt"></i> Remove All</a>
                    </div>

                    <div class="dropdown-menu col-9 p-2" aria-labelledby="dropdownMenuLink">
                        <div v-for="item in groupInsuranceList" :key="item.id" class="form-group row">
                            <div class="col-3">{{ item.first_name }}</div>
                            <div class="col-3">{{ item.last_name }}</div>
                            <div class="col-3">{{ item.dob }}</div>
                            <div class="col-3">
                                <a @click="removeItem(item)" class="btn btn-primary trashBtn btn-block text-white"><i class="fas fa-trash-alt"></i> Remove</a>
                            </div>
                        </div>
                    </div>
                </div> -->


            </div>
            </Transition>
            <button type="submit" class="btn btn-primary">Get Insurance</button>
        </form>
        
    </div>
</template>

<script>
import GroupInsurance from './GroupInsurance.vue';
import { ref } from 'vue';

export default {
    setup() {
        const date = ref(new Date());

        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}.${month}.${year}`;
        }

        const formatTime = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            const h = date.getHours();
            const m = date.getMinutes();

            return `${day}.${month}.${year} ${h}:${m}`;
        }

        return {
            date,
            format,
            formatTime
        }
    },
    name: 'TravelInsuranceForm',
    components: {
        GroupInsurance,
        // Datepicker
    },
    computed: {
        departureStartDate() {
            const date = new Date();
            date.setDate(date.getDate() + 1);

            return date;
        },
        getVacationLength() {
            const departureTs = this.departureDate.getTime();
            const returnTs = this.returnDate.getTime();

            return parseInt((returnTs - departureTs) / (24 * 3600 * 1000));
        }
    },
    data() {
        return {
            departureDate: null,
            returnDate: null,
            birthDate: null,
            individual: true,
            group: false,
            d_inline_block: 'd-inline-block',
            groupInsuranceList: [],
            isInvalid: '',
            error: false,
            success: false,
            message: '',
            invalidDeparture: false,
            invalidReturn: false,
            invalidDob: false
        }
    },
    methods: {
        changeOpacity() {
            this.individual = !this.individual;
            this.group = !this.group;
        },
        removeItem(item) {
            this.groupInsuranceList = this.groupInsuranceList.filter((listItem) => listItem !== item)
        },
        isNumeric(num) {
            if (num === '' || num === null) return false;

            if (!isNaN(num) && num.length > 6) {
                return true;
            } else {
                return false;
            }
        },
        makeInsurance(e) {
            let fieldEmpty = false;
            let filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            // let invalidFeedback = document.createElement('div');
            // invalidFeedback.classList.add('invalid-feedback-alt');
            // invalidFeedback.innerText = 'This field is mandatory.';
            // document.getElementsByName('departure')[0].classList.add('is-invalid');
            // let dateElements = document.querySelectorAll('.dp__input_wrap');


            // document.querySelectorAll('#travelInsuranceForm input').forEach(input => console.log(input.value));
            document.querySelectorAll('#travelInsuranceForm input').forEach(input => {
                if (input.id.startsWith('group') || !input.name) {
                    return;
                }

                if (!document.getElementsByName('departure')[0].value) {
                    fieldEmpty = true;
                    
                    this.invalidDeparture = true;
                } else {
                    this.invalidDeparture = false;
                    input.classList.add('is-valid');
                }

                if (!document.getElementsByName('return')[0].value) {
                    fieldEmpty = true;
                    
                    this.invalidReturn = true;
                } else {
                    this.invalidReturn = false;
                    input.classList.add('is-valid-alt');
                }

                if (!document.getElementsByName('dob')[0].value) {
                    fieldEmpty = true;
                    
                    this.invalidDob = true;
                } else {
                    this.invalidDob = false;
                    input.classList.add('is-valid');
                }

                if (!input.value) {
                    fieldEmpty = true;
                    
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    input.classList.add('is-valid');
                    input.classList.remove('is-invalid');
                }

            });


            if (!fieldEmpty) {
                let dateOfBirth = new Date(this.birthDate);
                let DD = String(dateOfBirth.getDate()).padStart(2, '0');
                let MM = String(dateOfBirth.getMonth() + 1).padStart(2, '0');
                let YYYY = dateOfBirth.getFullYear();
                dateOfBirth = YYYY + '-' + MM + '-' + DD;

                let formData = {
                    group: e.target.group ? e.target.group.value : 0,
                    first_name: e.target.first_name.value,
                    last_name: e.target.last_name.value,
                    email: e.target.email.value,
                    phone: e.target.phone.value,
                    dob: dateOfBirth,
                    // dob: e.target.dob._value,
                    departure: e.target.departure._value,
                    return: e.target.return._value,
                    from: e.target.from.value,
                    to: e.target.to.value,
                    groupInsuranceList: this.groupInsuranceList,
                };

                if (this.isNumeric(formData.phone)) {
                    document.querySelector('#phone').classList.remove('is-invalid');
                } else {
                    document.querySelector('#phone').classList.add('is-invalid');
                    document.querySelector('#phone').nextSibling.innerText = 'Phone Number should at least have 7 digits.';
                    return;
                }

                if (filter.test(formData.email)) {
                    document.querySelector('#email').classList.remove('is-invalid');
                } else {
                    document.querySelector('#email').classList.add('is-invalid');
                    document.querySelector('#email').nextSibling.innerText = 'This field has to be valid email.';
                    return;
                }

                axios({
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    url: '/travel-insurance/store',
                    data: formData
                })
                    .then(res => {
                        
                        if (res.data.error) {
                            
                            iziToast.error({
                                title: 'Error',
                                position: 'topCenter',
                                message: res.data.message,
                            });

                        }

                        if (res.data.success) {
                            
                            iziToast.success({
                                title: 'Success',
                                message: res.data.message,
                                position: 'topCenter'
                            });

                            document.querySelectorAll('#travelInsuranceForm input').forEach(input => {
                                input.value = '';
                                input.classList.remove('is-valid');
                            });

                            this.$emit('goToIntro');
                        }
                    })
                    .catch(error => console.log(error));
            }

        }
    }
}
</script>

<style>
#toggle {
    border-top: 1px solid rgba(255, 255, 255, 0.295);
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  bottom: 7px
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: #fff;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.textOpacity {
    opacity: 0.6;
}

#travelInsuranceForm {
    background-color: #1976d27c;
    padding: 2rem;
    border-radius: 0.4rem;
}

.trashBtn {
    cursor: pointer;
}

.invalid-feedback {
    color: #fff!important;
}

.groupInsuranceItem {
    border-top: 1px solid rgba(255, 255, 255, 0.295);
}

.groupForm {
    border: 1px solid rgba(255, 255, 255, 0.295);
    border-radius: 0.4rem;
    padding: 1rem 0 1rem 0;
}

.dp__pointer.is-invalid {
    border: 1px solid red;
}

.dp__pointer.is-valid {
    border-color: #28a745;
    padding-right: calc(1.5em + 0.75rem);
    /* background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e); */
    background-repeat: no-repeat;
    background-position: center right calc(0.375em + 0.1875rem);
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback-alt{
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 80%;
    color: #fff;
 }


</style>