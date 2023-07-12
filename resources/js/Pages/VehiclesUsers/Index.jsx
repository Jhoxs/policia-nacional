import { PlusOutlined } from '@ant-design/icons';
import { Button, message } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DependenceList from './Partials/DependenceList';
import SubcircuitsList from './Partials/SubcircuitsList';

const Index = ({ modelList, notSubc, haveSubc }) => {


    const dependeces = {
        d_usubcircuits: {
            titleCard: 'Vehículos sin Usuarios',
            totalCard: notSubc
        },
        d_unotsubcircuits: {
            titleCard: 'Vehículos con Usuarios',
            totalCard: haveSubc
        },

    }
    
    const { permissions } = usePage().props?.auth || [];

    return (
        <>
            <div className='flex justify-end'>
                {/* {permissions.includes('subcircuit.create') && (
                        <>
                            <Link href={route('subcircuit.create')}>
                                <Button
                                    type="primary"
                                    size="large"
                                    className="bg-[#52c41a] hover:bg-blue-100"
                                    icon={<PlusOutlined />}
                                >
                                    Asignar Subcircuito
                                </Button>
                            </Link>
                        </>
                    )
                } */}

            </div>

            <DependenceList dependeces={dependeces} />
            <div className="mt-12 ">
                <SubcircuitsList subcList={modelList} />
            </div>
        </>

    );
}

Index.layout = page => (<AuthenticatedLayout title="Asignaciones" children={page} />)


export default Index
