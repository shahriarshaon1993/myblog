<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-ticket icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Tags</div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <button @click="addModal=true" type="button" class="btn-shadow btn btn-info">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-plus fa-w-20"></i>
                            </span>
                            Add tags
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Active Users</div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Tag name</th>
                                <th class="text-center">Created at</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(tag,i) in tags" :key="i" v-if="tags.length">
                                <td class="text-center text-muted">{{ i+1 }}</td>
                                <td>{{ tag.tagName }}</td>
                                <td class="text-center">{{ tag.created_at }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-primary btn-sm" @click="showEditModel(tag, i)">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm" @click="showDeletingModal(tag, i)">Delete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tag Modal -->
                <Modal
                    v-model="addModal"
                    title="Add title"
                    :mask-closable="false"
                    :closable="false"
                    >
                    <Input v-model="data.tagName" placeholder="Enter tag name"/>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding...' : 'Add tag' }}</Button>
                    </div>

                </Modal>

                <!-- Tag adding modal -->
                <Modal
                    v-model="editModal"
                    title="Tag update"
                    :mask-closable="false"
                    :closable="false"
                    >
                    <Input v-model="editData.tagName" placeholder="Edit tag name"/>

                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Updating...' : 'Update tag' }}</Button>
                    </div>

                </Modal>

                <!-- Delete alert modal -->
                <Modal v-model="showDeleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure! you want to delete this tag ?</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
                    </div>
                </Modal>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                tagName: ''
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            tags: [],
            editData: {
                tagName: ''
            },
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deleteIndex: -1
        }
    },
    methods: {
        async addTag() {
            if(this.data.tagName.trim()=='') return this.error('Tag name is requried')
            const res = await this.callApi('post', 'app/create-tag', this.data)
            if(res.status === 201) {
                this.tags.unshift(res.data)
                this.success('Tag has been added successfully')
                this.addModal = false
                this.data.tagName = ''
            }else {
                if(res.status === 422) {
                    if(res.data.errors.tagName) {
                        this.error(res.data.errors.tagName[0])
                    }
                }else {
                    this.swr()
                }
            }
        },

        // Update tags in table
        async editTag() {
            if(this.editData.tagName.trim()=='') return this.error('Tag name is requried')
            const res = await this.callApi('post', 'app/edit-tag', this.editData)
            if(res.status === 200) {
                this.tags[this.index].tagName = this.editData.tagName
                this.success('Tag has been updated successfully')
                this.editModal = false
            }else {
                if(res.status === 422) {
                    alert(res.editData.errors.tagName[0])
                }else {
                    this.swr()
                }
            }
        },

        showEditModel(tag, index) {
            this.editModal = true
            let obj = {
                id: tag.id,
                tagName: tag.tagName
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },

        // Delete logic for tag
        async deleteTag() {
            this.isDeleting = true
            const res = await this.callApi('post', 'app/delete-tag', this.deleteItem)
            if(res.status === 200) {
                this.tags.splice(this.deletingIndex, 1)
                this.success('Tag has been deleted successfully!')
            }
            this.isDeleting = false
            this.showDeleteModal = false
        },


        showDeletingModal(tag, i) {
            this.deleteItem = tag
            this.deleteIndex = i
            this.showDeleteModal = true
        }
    },
    async created() {
        const res = await this.callApi('get', 'app/get-tag')

        if(res.status === 200) {
            this.tags = res.data
        }else {
            this.swr()
        }
    },
}
</script>
