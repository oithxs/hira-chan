import React from "react";
import { isset } from "@/utils/isType";
import { type HTMLAttributes } from "react";

export default function InputError({
    message,
    className = "",
    ...props
}: HTMLAttributes<HTMLParagraphElement> & { message?: string }): JSX.Element | null {
    return isset(message) ? (
        <p {...props} className={"text-sm text-red-600 dark:text-red-400 " + className}>
            {message}
        </p>
    ) : null;
}
