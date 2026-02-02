<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';

import { index as inviteIndex } from '@/actions/App/Http/Controllers/InvitationController';
import { index as usersIndex } from '@/actions/App/Http/Controllers/UserController';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import InviteUserModal from '@/pages/central/user/InviteUserModal.vue';

const page = usePage();
</script>

<template>
    <div class="flex items-center justify-end">
        <NavigationMenu>
            <NavigationMenuList>
                <NavigationMenuItem>
                    <NavigationMenuLink
                        as-child
                        :class="[
                            navigationMenuTriggerStyle(),
                            page.url === '/users' && 'bg-accent',
                        ]"
                    >
                        <Link :href="usersIndex()">Users</Link>
                    </NavigationMenuLink>
                </NavigationMenuItem>
                <NavigationMenuItem>
                    <NavigationMenuLink
                        as-child
                        :class="[
                            navigationMenuTriggerStyle(),
                            page.url === '/users/open-invites' && 'bg-accent',
                        ]"
                    >
                        <Link :href="inviteIndex()">Open Invites</Link>
                    </NavigationMenuLink>
                </NavigationMenuItem>
                <NavigationMenuItem class="ml-3">
                    <InviteUserModal />
                </NavigationMenuItem>
            </NavigationMenuList>
        </NavigationMenu>
    </div>
</template>
