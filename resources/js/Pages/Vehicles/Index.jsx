import { PlusOutlined } from '@ant-design/icons';
import { Button, message } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import VehicleTable from './Partials/VehicleTable';

const Index = ({ modelData }) => {

    const { permissions } = usePage().props?.auth || [];

    return (
        <>
            <div className='flex justify-end'>
                {
                    permissions.includes('vehicle.create') && (
                        <>
                            <Link href={route('vehicle.create')}>
                                <Button
                                    type="primary"
                                    size="large"
                                    className="bg-[#52c41a] hover:bg-blue-100"
                                    icon={<PlusOutlined />}
                                >
                                    Crear Vehículo
                                </Button>
                            </Link>
                        </>
                    )
                }

            </div>

            <div className="mt-12 ">
                <VehicleTable
                    modelList={modelData}
                ></VehicleTable>
            </div>
        </>

    );
}

Index.layout = page => (<AuthenticatedLayout title="Vehículos" children={page} />)


export default Index
