<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <!-- Load Material Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- Load File Vuetify css CDN -->
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
    <div id="app">
    <v-app>
        <v-main>
            <v-container>
                <!-- Table List Product -->
                <template>
                    <!-- Button Add New Product -->
                    <template>
                        <v-btn color="primary" dark @click="modalAdd = true">Add New</v-btn>
                    </template>
                    
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">Product Name</th>
                                <th class="text-left">Price</th>
                                <th class="text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products" :key="product.product_id">
                                <td>{{ product.product_name }}</td>
                                <td>{{ product.product_price }}</td>
                                <td>
                                <template>
                                    <v-icon small class="mr-2" @click="editItem(product)">
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon small @click="deleteItem(product)">
                                        mdi-delete
                                    </v-icon>
                                </template>
                                </td>
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>

                </template>
                <!-- End Table List Product -->
                
                <!-- Modal Save Product -->
                <template>
                    <v-dialog v-model="modalAdd" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                                <span class="headline">Add New Product</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field label="Product Name*" v-model="productName" required>
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field label="Price*" v-model="productPrice" required>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>*indicates required field</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="modalAdd = false">Close</v-btn>
                                <v-btn color="blue darken-1" text @click="saveProduct">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </template>
                <!-- End Modal Save Product -->

                <!-- Modal Edit Product -->
                <template>
                    <v-dialog v-model="modalEdit" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                                <span class="headline">Edit Product</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field label="Product Name*" v-model="productNameEdit" required>
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field label="Price*" v-model="productPriceEdit" required>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>*indicates required field</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="modalEdit = false">Close</v-btn>
                                <v-btn color="blue darken-1" text @click="updateProduct">Update</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </template>
                <!-- End Modal Edit Product -->

                <!-- Modal Delete Product -->
                <template>
                    <v-dialog v-model="modalDelete" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                                <span class="headline"></span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <h3>Are sure want to delete <strong>"{{ productNameDelete }}"</strong> ?</h3>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="modalDelete = false">No</v-btn>
                                <v-btn color="info darken-1" text @click="deleteProduct">Yes
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </template>
                <!-- End Modal Delete Product -->

            </v-container>
        </v-main>
    </v-app>
    </div>

    <!-- Load File Vue js CDN -->
    <script src="https://vuejs.org/js/vue.min.js"></script>
    <!-- Load File Vuetify js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data : {
                products: [],
                modalAdd: false,
                productName: '',
                productPrice: '',
                modalEdit: false,
                productIdEdit: '',
                productNameEdit: '',
                productPriceEdit: '',
                modalDelete: false,
                productIdDelete: '',
                productNameDelete: '',
            },
            created: function() {
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                this.getProducts();
            },
            methods: {
                // Get Product
                getProducts: function () {
                    axios.get('product/getproduct')
                        .then(res => {
                             // handle success
                            this.products = res.data;
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },
                // Save Product
                saveProduct: function(){
                    axios.post('product/save', {
                        product_name: this.productName,
                        product_price: this.productPrice
                    })
                    .then(res => {
                        // handle success
                        this.getProducts();
                        this.productName = '';
                        this.productPrice = '';
                        this.modalAdd = false;
                    })
                    .catch(err => {
                        // handle error
                        console.log(err);
                    })
                },

                // Get Item Edit Product
                editItem: function(product) {
                    this.modalEdit = true;
                    this.productIdEdit    = product.product_id;
                    this.productNameEdit  = product.product_name;
                    this.productPriceEdit = product.product_price;
                },

                //Update Product
                updateProduct: function () {
                    axios.put(`product/update/${this.productIdEdit}`, {
                            product_name: this.productNameEdit,
                            product_price: this.productPriceEdit
                        })
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.modalEdit = false;
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },

                // Get Item Delete Product
                deleteItem: function(product){
                    this.modalDelete = true;
                    this.productIdDelete    = product.product_id;
                    this.productNameDelete  = product.product_name;
                },

                // Delete Product
                deleteProduct: function () {
                    axios.delete(`product/delete/${this.productIdDelete}`)
                        .then(res => {
                            // handle success
                            this.getProducts();
                            this.modalDelete = false;
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                }

            },
            
        })
    </script>
</body>
</html>