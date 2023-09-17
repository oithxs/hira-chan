import Footer from "@/Components/Layouts/Footer";
import Header from "@/Components/Layouts/Header";
import { isset } from "@/utils/isType";
import { Head } from "@inertiajs/react";
import React, { type ReactNode, type PropsWithChildren } from "react";

interface MainLayoutProps {
    title?: string;
    metas?: ReactNode;
    styles?: ReactNode;
    scripts?: ReactNode;
}

export default function MainLayout({
    children,
    title,
    metas,
    styles,
    scripts,
}: PropsWithChildren<MainLayoutProps>): JSX.Element {
    return (
        <>
            <Head title={title}>
                {isset(metas) && metas}
                {isset(styles) && styles}
            </Head>
            <Header />
            {children}
            <Footer />
            {isset(scripts) && scripts}
        </>
    );
}
