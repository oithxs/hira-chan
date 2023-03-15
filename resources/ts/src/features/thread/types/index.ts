/** スレッドの情報 */
export type threadEntity = {
    id: string;
    thread_secondary_category_id: number;
    user_id: string;
    name: string;
    created_at: string;
    updated_at: string;
    deleted_at: string;
    thread_secondary_category: {
        id: number;
        thread_primary_category_id: number;
        name: string;
        created_at: string;
        updated_at: string;
    };
    access_logs_count: number;
};

/** 詳細カテゴリの情報 */
export type threadSecondaryCategoryEntity = {
    id: number;
    thread_primary_category_id: number;
    name: string;
    created_at: string;
    updated_at: string;
    thread_primary_category: {
        id: number;
        name: string;
        created_at: string;
        updated_at: string;
    };
};

/** 大枠カテゴリの情報 */
export type threadPrimaryCategoryEntity = {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
    thread_secondary_category: {
        id: number;
        thread_primary_category_id: number;
        name: string;
        created_at: string;
        updated_at: string;
    };
};
