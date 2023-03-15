import { ReactNode } from "react";

type FormProps = {
    children: ReactNode;
};

export const Form = ({ children }: FormProps) => {
    return <form className="align-items-center">{children}</form>;
};
