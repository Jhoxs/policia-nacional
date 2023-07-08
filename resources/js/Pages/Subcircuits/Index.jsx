import { PlusOutlined } from '@ant-design/icons';
import { Button, message } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DependenceList from './Partials/DependenceList';
import SubcircuitsList from './Partials/SubcircuitsList';

const Index = ({ subcList, provinces, parishes, cities, circuits }) => {
    const dependeces = {
        d_provinces: {
            titleCard: 'Provincias',
            totalCard: provinces
        },
        d_parishes: {
            titleCard: 'Parroquias',
            totalCard: parishes
        },
        d_cities: {
            titleCard: 'Ciudades',
            totalCard: cities
        },
        d_circuits: {
            titleCard: 'Circuitos',
            totalCard: circuits
        },

    }

    const { permissions } = usePage().props?.auth || [];

    return (
        <>
            <div className='flex justify-end'>
                {permissions.includes('subcircuit.create') && (
                        <>
                            <Link href={route('subcircuit.create')}>
                                <Button
                                    type="primary"
                                    size="large"
                                    className="bg-[#52c41a] hover:bg-blue-100"
                                    icon={<PlusOutlined />}
                                >
                                    Crear Subcircuito
                                </Button>
                            </Link>
                        </>
                    )
                }

            </div>

            <DependenceList dependeces={dependeces} />
            <div className="mt-12 ">
                <SubcircuitsList subcList={subcList} />
            </div>
        </>

    );
}

Index.layout = page => (<AuthenticatedLayout title="Dependencias" children={page} />)


export default Index
