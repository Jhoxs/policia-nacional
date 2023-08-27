import { PlusOutlined } from '@ant-design/icons';
import { Button, message } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import ModelTable from './Partials/ModelTable';

const Index = ({ modelData }) => {

    const { permissions } = usePage().props?.auth || [];

    return (
        <>
            <div className='flex justify-end'>
                {
                    permissions.includes('contract.create') && (
                        <>
                            <Link href={route('contract.create')}>
                                <Button
                                    type="primary"
                                    size="large"
                                    className="bg-[#52c41a] hover:bg-blue-100"
                                    icon={<PlusOutlined />}
                                >
                                    Crear Contrato
                                </Button>
                            </Link>
                        </>
                    )
                }

            </div>

            <div className="mt-12 ">
                <ModelTable
                    modelList={modelData}
                ></ModelTable>
            </div>
        </>

    );
}

Index.layout = page => (<AuthenticatedLayout title="Contratos" children={page} />)


export default Index
