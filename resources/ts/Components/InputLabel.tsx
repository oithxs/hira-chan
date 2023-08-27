import React from "react";
import { isset } from "@/utils/isType";
import { type LabelHTMLAttributes } from "react";

export default function InputLabel({
    value,
    className = "",
    children,
    ...props
}: LabelHTMLAttributes<HTMLLabelElement> & { value?: string }): JSX.Element {
    return (
        <label {...props} className={`block font-medium text-sm text-gray-700 dark:text-gray-300 ` + className}>
            {isset(value) ? value : children}
        </label>
    );
}
