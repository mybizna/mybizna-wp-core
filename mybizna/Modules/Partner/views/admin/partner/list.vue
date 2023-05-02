<template>
    <table-render title="Partner" :path_param="['partner', 'partner']" :table_fields="table_fields">

        <template #header>
            <th-render>First Name</th-render>
            <th-render>Last Name</th-render>
            <th-render>Email</th-render>
            <th-render>Phone</th-render>
            <th-render>Mobile</th-render>
            <th-render>Country</th-render>
        </template>

        <template #body="{ item }">
            <td>{{ item.first_name }}</td>
            <td>{{ item.last_name }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.phone }}</td>
            <td>{{ item.mobile }}</td>
            <td>
                {{ item.country_id__core_country__name }}
                <span v-if="item.country_id__core_country__code">
                    ({{ item.country_id__core_country__code }})
                </span>
            </td>
        </template>

    </table-render>
</template>

<script>
export default {
    data() {
        return {
            table_fields: [
                'first_name', 'last_name', 'email', 'phone', 'mobile',
                'country_id__core_country__name', 'country_id__core_country__code',
            ],
        };
    },
};
</script>
