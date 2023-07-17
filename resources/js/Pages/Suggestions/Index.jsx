import { PlusOutlined } from '@ant-design/icons';
import { Button, message } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DependenceList from './Partials/DependenceList';
import SubcircuitsList from './Partials/SubcircuitsList';

const Index = ({ modelList, suggestion, claim }) => {


    const dependeces = {
        d_usubcircuits: {
            titleCard: 'Sugerencias',
            totalCard: suggestion
        },
        d_unotsubcircuits: {
            titleCard: 'Reclamos',
            totalCard: claim
        },

    }
    
    const { permissions } = usePage().props?.auth || [];

    return (
        <>
            <DependenceList dependeces={dependeces} />
            <div className="mt-12 ">
                <SubcircuitsList subcList={modelList} />
            </div>
        </>

    );
}

Index.layout = page => (<AuthenticatedLayout title="Asignaciones" children={page} />)


export default Index
