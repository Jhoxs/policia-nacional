import { usePage } from "@inertiajs/react";
import { Alert } from 'antd';
import React, { useEffect, useState } from "react"

export default function FlashMessage() {

    const [visible, setVisible] = useState(true);
    const { flash, errors } = usePage().props;
    const numOfErrors = Object.keys(errors).length;


    const handleClose = () => {
        setVisible(false);
    }

    useEffect(() => {
        if (flash.success || flash.error || numOfErrors > 0) {
            setVisible(true);
            const timer = setTimeout(() => {
                handleClose();
            }, 3000); // Cerrar la alerta después de 5 segundos

            return () => {
                clearTimeout(timer); // Limpiar el temporizador al desmontar el componente
            };
        }
    }, [flash, errors]);

    
    return (
        <>
            {flash.success && visible && (
                <Alert message={flash.success} type="success" showIcon afterClose={handleClose} />
            )}
            {/* {(flash.error || numOfErrors > 0) && visible && (
                <>
                    {flash.error && flash.error}
                    {numOfErrors === 1 && (flashContainer(flash.error, 'error'))}
                    {numOfErrors > 1 && (flashContainer(`Existen un total de ${numOfErrors} errores.`, 'error'))}
                </>
            )} */}
        </>
    );
}