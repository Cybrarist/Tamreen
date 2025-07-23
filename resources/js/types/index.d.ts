import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;


export type Item = {
    id: number;
    name: string;
    image: string;
    exercise_plans: ExercisePlan[];
}

export type Exercise = {
    id: number;
    name: string;
    image: string;
    description: string;
    type_id: number;
    images : string[];
    videos: string[];
    unit: string;
    body_parts: BodyPart[];
    type: Type,

}

export type Type = {
    id: number;
    name: string;
}

export type ExercisePlanTemplate = {
    id: number;
    name: string;
    description: string;
    exercises: {
        exercise: Exercise;
        multiplier: number;
    }[];
}
export type ExercisePlan = {
    id: number;
    name: string;
    description: string;
    exercises: {
        exercise: Exercise;
        multiplier: number;
    }[];
}

export type BodyPart = {
    id: number;
    name: string;
    image: ?string ;
    exercises: Exercise[];
}

export type Workout = {
    id: number;
    exercise_plan: ExercisePlan;
    exercises: Exercise[];
    item: Item;
}
