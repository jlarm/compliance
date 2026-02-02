<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';

import { store } from '@/actions/App/Http/Controllers/UserController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';

const open = ref(false);
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button>Invite User</Button>
        </DialogTrigger>
        <DialogContent>
            <Form
                :action="store()"
                #default="{ errors, processing, reset, clearErrors }"
                resetOnSuccess
                @success="open = false"
            >
                <DialogHeader>
                    <DialogTitle>Invite User</DialogTitle>
                </DialogHeader>
                <div class="grid gap-3 py-4">
                    <Input
                        type="email"
                        name="email"
                        placeholder="Email Address"
                    />

                    <InputError :message="errors.email" />
                </div>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button
                            variant="secondary"
                            @click="
                                () => {
                                    clearErrors();
                                    reset();
                                }
                            "
                            >Cancel</Button
                        >
                    </DialogClose>
                    <Button type="submit" :disabled="processing"
                        >Send Invite</Button
                    >
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
