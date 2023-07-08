import { PlusOutlined } from '@ant-design/icons';
import { Button, message } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DependenceList from './Partials/DependenceList';
import ModelList from './Partials/ModelList';

const Index = ({ modelList, provinces, circuits, cities, subcircuits }) => {
    const dependeces = {
        d_provinces: {
            titleCard: 'Provincias',
            totalCard: provinces
        },
        d_circuits: {
            titleCard: 'Circuitos',
            totalCard: circuits
        },
        d_cities: {
            titleCard: 'Ciudades',
            totalCard: cities
        },
        d_subcircuits:{
            titleCard: 'Subcircuitos',
            totalCard: subcircuits
        }

    }

    const { permissions } = usePage().props?.auth || [];

    return (
        <>
            <div className='flex justify-end'>
                {permissions.includes('parish.create') && (
                        <>
                            <Link href={route('parish.create')}>
                                <Button
                                    type="primary"
                                    size="large"
                                    className="bg-[#52c41a] hover:bg-blue-100"
                                    icon={<PlusOutlined />}
                                >
                                    Crear Parroquia
                                </Button>
                            </Link>
                        </>
                    )
                }

            </div>

            <DependenceList dependeces={dependeces} />
            <div className="mt-12 ">
                <ModelList modelList={modelList} />
            </div>
        </>

    );
}

Index.layout = page => (<AuthenticatedLayout title="Dependencias" children={page} />)


export default Index
