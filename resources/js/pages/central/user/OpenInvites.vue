<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { PropType } from 'vue';

import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import UserNavigation from '@/pages/central/user/UserNavigation.vue';
import invitation from '@/routes/invitation';
import { type BreadcrumbItem } from '@/types';

interface Invitation {
    id: number;
    email: string;
    created_at: string;
}

interface InvitationCollection {
    data: Invitation[];
}

defineProps({
    invitations: {
        type: Object as PropType<InvitationCollection[]>,
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Open Invitations',
        href: invitation.index().url,
    },
];
</script>

<template>
    <Head title="Open Invites" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex items-center justify-end p-3">
            <UserNavigation />
        </div>
        <div class="p-3">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Email</TableHead>
                        <TableHead>Date Sent</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="invitation in invitations"
                        :key="invitation.id"
                    >
                        <TableCell>{{ invitation.email }}</TableCell>
                        <TableCell>{{ invitation.created_at }}</TableCell>
                        <TableCell class="flex justify-end">
                            <ButtonGroup>
                                <Button variant="outline" size="sm"
                                    >Resend Invite</Button
                                >
                                <Button variant="destructive" size="sm"
                                    >Delete</Button
                                >
                            </ButtonGroup>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
