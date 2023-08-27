import { Button, Result } from 'antd';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

const Unauthorized = ({ response }) => {

    return (
        <>
            <Result
                status={response.status}
                title={response.title}
                subTitle={response.subTitle}
            />
        </>
    );
}

Unauthorized.layout = page => (<AuthenticatedLayout title="Unauthorized" children={page} />)


export default Unauthorized